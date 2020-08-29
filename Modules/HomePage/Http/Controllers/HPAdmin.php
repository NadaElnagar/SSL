<?php


namespace Modules\HomePage\Http\Controllers;

use Illuminate\Http\Request;
use Laminas\Diactoros\Response;
use Modules\HomePage\Http\Requests\SliderRequest;
use Modules\HomePage\Http\Requests\SliderRequestUpdate;
use Modules\HomePage\Http\Service\HPService;
use Illuminate\Routing\Controller;

class HPAdmin extends Controller
{
    private $home_page;
    public function __construct()
    {
        $this->home_page = new HPService();
    }
    public function index(Request $request)
    {
        return $this->home_page->index($request);
    }
    public function show($id)
    {
        return $this->home_page->show($id);
    }
    public function store(SliderRequest $request)
    {
        return $this->home_page->store($request);
    }
    public function destroy($id)
    {
        return $this->home_page->delete($id);
    }
    public function update($id,SliderRequestUpdate $request)
    {
        return $this->home_page->edit($id,$request);
    }
    public function getSliderFront(Request $request)
    {
        $lang = $request->header('Content-Language');
        if(!$lang) $lang='en';
        return $this->home_page->getSliderFront($lang);
    }
}
