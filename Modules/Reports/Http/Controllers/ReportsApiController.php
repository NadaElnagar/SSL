<?php


namespace Modules\Reports\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Reports\Http\Requests\OrdersRequest;
use Modules\Reports\Http\Service\CartService;
use Modules\Reports\Http\Service\CertificatesSellingService;
use Modules\Reports\Http\Service\CustomersService;
use Modules\Reports\Http\Service\DashboardService;
use Modules\Reports\Http\Service\OrdersService;

class ReportsApiController extends Controller
{
    /*Total orders,Payments,Registered customers,Brands,Categories,Products*/
    public function dashboard()
    {
        return (new DashboardService())->dashboard();
    }

    public function dashboardPdf()
    {
        return (new DashboardService())->pdf();
    }

    public function customer()
    {
        return (new CustomersService())->index();
    }
    public function customerPdf()
    {
        return (new CustomersService())->pdf();
    }
    public function cart()
    {
        return (new CartService())->index();
    }
    public function cartPdf()
    {
        return (new CartService())->pdf();
    }

    public function orders(OrdersRequest $request)
    {
        return (new OrdersService())->index($request);
    }
    public function ordersPdf(OrdersRequest $request)
    {
        return (new OrdersService())->pdf($request);
    }
    public function certificate()
    {
        return (new CertificatesSellingService())->index();
    }
    public function certificatePdf()
    {
        return (new CertificatesSellingService())->pdf();
    }
}
