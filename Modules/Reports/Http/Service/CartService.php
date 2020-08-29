<?php


namespace Modules\Reports\Http\Service;


use App\Http\Services\ResponseService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;
use Modules\Reports\Http\Repository\CartRepository;

class CartService extends ResponseService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = new CartRepository();
    }

    public function index()
    {
        $data = $this->cart->index();
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
    public function pdf()
    {
        $data = $this->cart->index();
        $pdf = PDF::loadView('reports::pdf/cart', array('data' => $data));
        $file = $pdf->download('cart.pdf');
        $data = chunk_split(base64_encode(($file)));
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
}
