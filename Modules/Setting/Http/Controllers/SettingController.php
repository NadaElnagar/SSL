<?php

namespace Modules\Setting\Http\Controllers;

 use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
 use Modules\Setting\Http\Requests\SettingRequest;
 use Modules\Setting\Http\Requests\SettingRequestUpdate;
 use Modules\Setting\Http\Service\SettingService;

class SettingController extends Controller
{
    private $setting;
    public function __construct()
    {
        $this->setting = new SettingService();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return $this->setting->index();
    }

//    /**
//     * Show the form for creating a new resource.
//     * @return Response
//     */
//    public function create()
//    {
//        return view('faq::create');
//    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(SettingRequest $request)
    {
        $header = $request->header('Accept-Language');
        if($header) $request['lang'] = $header; else  $request['lang'] = 'en';
        return $this->setting->store($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->setting->show($id);
    }

//    /**
//     * Show the form for editing the specified resource.
//     * @param int $id
//     * @return Response
//     */
//    public function edit($id)
//    {
//        return view('faq::edit');
//    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(SettingRequestUpdate $request, $id)
    {

        return $this->setting->update($id,$request);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->setting->destroy($id);
    }
}
