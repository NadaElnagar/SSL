<?php


namespace Modules\HomePage\Http\Controllers;


use App\Http\Requests\pagination;
use Illuminate\Routing\Controller;
use Modules\HomePage\Http\Requests\HPCollectionRequest;
use Modules\HomePage\Http\Requests\HPCollectionRequestupdate;
use Modules\HomePage\Http\Service\HPCollectionService;
use Illuminate\Http\Request;

class HPCollectionController extends Controller
{
    protected $collection;
    public function __construct()
    {
        $this->collection = new HPCollectionService();
    }
    public function store(HPCollectionRequest $request)
    {
        return $this->collection->store($request);
    }
    public function show($id)
    {
        return $this->collection->show($id);
    }
    public function index(pagination $request)
    {
        return $this->collection->index($request);
    }
    public function destroy($id)
    {
        return $this->collection->delete($id);
    }
    public function update($id,HPCollectionRequestupdate $request)
    {
        return $this->collection->update($id,$request);
    }
}
