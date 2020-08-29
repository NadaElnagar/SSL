<?php

namespace Modules\FAQ\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\FAQ\Http\Requests\FaqRequest;
use Modules\FAQ\Http\Service\FaqService;

class FAQControllerApi extends Controller
{
    private $faq;
    public function __construct()
    {
        $this->faq = new FaqService();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return $this->faq->index();
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
    public function store(FaqRequest $request)
    {
        return $this->faq->store($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->faq->show($id);
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
    public function update(Request $request, $id)
    {
        return $this->faq->update($id,$request);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
       return $this->faq->destroy($id);
    }
}
