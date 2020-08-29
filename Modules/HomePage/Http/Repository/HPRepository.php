<?php


namespace Modules\HomePage\Http\Repository;


use App\Http\Repository\BaseRepository;
use Modules\HomePage\Entities\slider;
use Modules\HomePage\Entities\SliderText;

class HPRepository
{

    public function index($request)
    {
        $result = array();
        $slider = ((new slider())->newQuery())->with('text');
        $slider_repository = (new BaseRepository())->paginationRepository($request,$slider);
        $result['count'] = $slider_repository['count'];
        $result['slider'] = $slider_repository['data'];
        return $result;
    }

    public function show($id)
    {
        return slider::with('text')->find($id);
    }

    public function store($data)
    {
        $slider = new slider();
        $slider->url = $data['url'];
        $slider->image = upload_image_base64('slider', $data['image']);
        if ($data['active'] ==0  || $data['active']==1  ) $slider->active = $data['active'];
        if ($slider->save()) {
            if ($data['text']) {
                $this->save_slider_text($slider->id, $data['text']);
            }
            return true;
        } else {
            return false;
        }
    }

    private function save_slider_text($slider_id, $data)
    {
        $text = json_decode(json_encode($data,true));
        foreach ($text as $details) {
            $slider = new SliderText();
            $slider->slider_id = $slider_id;
            $slider->text = $details->text;
            $slider->lang = $details->lang;
            $slider->save();
        }
        return true;
    }

    public function edit($id, $data)
    {
       if($slider = slider::find($id)) {
           if ($data['url']) $slider->url = $data['url'];
           if ($data['image']) {
               un_link_image('slider', $slider->image);
               $slider->image = upload_image_base64('slider', $data['image']);
           }
           if ($data['text']) {
               SliderText::where('slider_id', $id)->delete();
               $this->save_slider_text($slider->id, $data['text']);
           }

           if ($data['active'] ==0  || $data['active']==1  ){
               $slider->active = $data['active'];
           }

           $slider->update();
               return slider::with('text')->find($id);
       }else{
           return false;
       }
    }

    public function delete($id)
    {
        $slider = slider::find($id);
        SliderText::where('slider_id',$id)->delete();
        un_link_image('slider', $slider->image);
        return $slider->delete();
    }

    public function getSliderFront($lang)
    {
        return  slider::where('active', 1)->with(['text'=> function ($q) use ($lang) {
        return $q->where('lang', $lang)->take(1);
    }])->get();
    }
}
