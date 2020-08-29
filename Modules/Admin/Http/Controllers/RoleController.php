<?php


namespace Modules\Admin\Http\Controllers;
use App\Http\Requests\pagination;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\Role;
use Modules\Admin\Http\Requests\RoleUpdate;
use Modules\Admin\Http\Service\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $role;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->role = new RoleService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->role->index();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Role $request)
    {
        return $this->role->store($request);
    }

    /**
     *   for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->role->edit($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,RoleUpdate $request)
    {
        return $this->role->update($id,$request);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->role->destroy($id);
    }
    public function listPermission()
    {
        return $this->role->listPermission();
    }
    public function getAllRoleRelatdPermission(pagination $request)
    {
        return $this->role->getAllRoleRelatdPermission($request);
    }
}
