<?php


namespace Modules\FAQ\Http\Repository;


use Modules\FAQ\Entities\FAQ;

class FaqRepository
{

    public function index()
    {
        return FAQ::all();
    }
    public function store($data)
    {
        $faq = new FAQ();
        $faq->title = $data['title'];
        $faq->question = $data['question'];
        $faq->answer = $data['answer'];
        if($faq->save())
        {
            return $faq;
        }else{
            return false;
        }
    }
    public function show($id)
    {
        return FAQ::find($id);
    }
    public function update($id,$data)
    {
        $faq = FAQ::find($id);
        if($data['title']) $faq->title = $data['title'];
        if($data['question']) $faq->question = $data['question'];
        if($data['answer']) $faq->answer = $data['answer'];
        if($faq->update())
        {
            return  FAQ::find($id);
        }else{
            return false;
        }
    }
    public function destroy($id)
    {
        if ($fqa = FAQ::find($id))
        {
            $fqa->delete();
            return true;
        }else{
            return false;
        }
    }
}
