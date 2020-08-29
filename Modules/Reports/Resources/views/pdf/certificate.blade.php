<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ 'Certificate Report' }}</title>
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
<h2>{{ 'Low, Top Sealing and orders'}}</h2>
<h4>Orders</h4>
<table width="100%" style="width:100%" border=".5">
    <tr>
        <td><h3>Total Money</h3></td>
        <td><h3>Total Order</h3></td>
        <td><h3>Number Cart</h3></td>
        <td><h3>Number Of Months</h3></td>
        <td><h3>Product Name</h3></td>
    </tr>
    @if($data)
        @foreach($data['orders'] as $orders)
            <tr>
                <td>{{$orders['total_money']}}</td>
                <td>{{$orders['total_order']}}</td>
                <td>{{$orders['number_cart']}}</td>
                <td>{{$orders['price'][0]['number_of_months']}}</td>
                <td>{{$orders['price'][0]['product']['product_name']}}</td>
            </tr>
        @endforeach
    @endif

</table>
<h4>Low Sealing</h4>
<table width="100%" style="width:100%" border=".5">
    <tr>
        <td><h3>Number Of Months</h3></td>
        <td><h3>price</h3></td>
        <td><h3>Product Name</h3></td>
    </tr>
    @if($data)
        @foreach($data['low_sealing'] as $low_sealing)
            <tr>
                <td>{{$low_sealing['number_of_months']}}</td>
                <td>{{$low_sealing['price']}}</td>
                <td>{{$low_sealing['product']['product_name']}}</td>
            </tr>
        @endforeach
    @endif

</table>
<h4>Top 5 Sealing</h4>
<table width="100%" style="width:100%" border=".5">
    <tr>
        <td><h3>Number Of Months</h3></td>
        <td><h3>price</h3></td>
        <td><h3>Product Name</h3></td>
    </tr>
    @if($data)
        @foreach($data['top_sealing'] as $top_sealing)
            <tr>
                <td>{{$top_sealing['number_of_months']}}</td>
                <td>{{$top_sealing['price']}}</td>
                <td>{{$top_sealing['product']['product_name']}}</td>
            </tr>
        @endforeach
    @endif

</table>
</body>
</body>
</html>
