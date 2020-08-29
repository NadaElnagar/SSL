<?php


namespace Modules\Admin\Http\Controllers;
use App\Http\Requests\pagination;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\CheckLoginAdmin;
use Modules\Admin\Http\Requests\NewAdmin;
use Modules\Admin\Http\Requests\NewAdminUpdate;
use Modules\Admin\Http\Service\AdminService;

class AdminControllerApi extends Controller
{
    private  $admin;
    public function __construct()
    {
        $this->admin = new AdminService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(pagination $request)
    {
        return $this->admin->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewAdmin $request)
    {
        return $this->admin->store($request);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->admin->show($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewAdminUpdate $request, $id)
    {
        return $this->admin->update($request,$id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->admin->destroy($id);
    }
}
