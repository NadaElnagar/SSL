<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ 'Orders Report' }}</title>
    <style>
        table, td, th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 15px;
        }
    </style>
</head>
<body>
<h2><span  >{{'Total Orders: '.$data['total_order']}}</span></h2>
<h3 style="float: right"><    <span >{{'Total Orders from ('.$from.' - '. $to.") : ".sizeof($data['orders_history'])}}</span></h3>
<h2>Orders Status</h2>
<table width="99%" style="width:100%" border=".5">
    <tr>
        <td><h4>Major Status</h4></td>
        <td><h4>Total</h4></td>
    </tr>

    @if($data)
        @foreach($data['status'] as $status)
            <tr>
                <td>{{$status->major_status}}</td>
                <td>{{$status->total}}</td>
            </tr>
        @endforeach
    @endif
</table>
<h2>{{ 'Orders Report'}}</h2>
<table width="99%" style="width:100%" border=".5">
    <tr>
        <td><h4>user mail</h4></td>
        <td><h4>Product Name</h4></td>
        <td><h4>Certificate Number Months</h4></td>
        <td><h4>Certificate Start Date </h4></td>
        <td><h4>Certificate End Date</h4></td>
        <td><h4>Certificate Price</h4></td>
    </tr>

    @if($data)
        @foreach($data['orders_history'] as $order)
            <tr>
                <td>{{$order->userMail}}</td>
                <td>{{$order->product_name}}</td>
                <td>{{$order->number_of_months}}</td>
                <td>{{$order->certificate_start_date}}</td>
                <td>{{$order->CertificateEndDate}}</td>
                <td>{{$order->price}}</td>
            </tr>
        @endforeach
    @endif
</table>

</body>
</body>
</html>
