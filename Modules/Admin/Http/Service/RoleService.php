<?php


namespace Modules\Admin\Http\Service;


use App\Http\Services\ResponseService;
use Modules\Admin\Http\Repository\RoleRepository;
use Illuminate\Http\Response;

class RoleService extends ResponseService
{
    private $role;
    public function __construct()
    {
        $this->role = new RoleRepository();
    }
    public function index()
    {
        $data = $this->role->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function store($data)
    {
        $data = $this->role->store($data);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
    public function update($id,$data)
    {
        $data = $this->role->update($id,$data);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
    public function destroy($id)
    {
        $data = $this->role->destroy($id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __('messages.Error, Please Try again Letter'));
        }
    }

    public function edit($id)
    {
        $data = $this->role->edit($id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }

    }
    public function listPermission()
    {
        $data = $this->role->listPermission();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    public function getAllRoleRelatdPermission($request)
    {
        $data = $this->role->getAllRoleRelatdPermission($request);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
}
