<?php


namespace Modules\HomePage\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\HomePage\Http\Service\HPCollectionService;
use Illuminate\Http\Request;

class HPCollectionFrontController extends Controller
{
    private $collection;
    public function __construct()
    {
        $this->collection = new HPCollectionService();
    }
    public function frontListCollection(Request $request)
    {
        $lang = $request->header('Content-Language');
        if(!$lang) $lang='en';
        return $this->collection->frontListCollection($lang);
    }
}
