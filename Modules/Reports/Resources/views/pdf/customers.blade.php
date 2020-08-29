<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ 'Customers Report' }}</title>
</head>
<body>
<h2>{{ 'Customers Report'}}</h2>
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
<table width="100%" style="width:100%" border=".5">
    <tr>
        <td><h3>user Email</h3></td>
        <td><h3>Total Orders</h3></td>
        <td><h3>Total Cart</h3></td>
        <td><h3>Total Ticket</h3></td>
        <td><h3>Total Wallet</h3></td>
        <td><h3>Total Money</h3></td>
    </tr>

    @if($data)
        @foreach($data as $customer)
            <tr>
                <td>{{$customer['user']}}</td>
                <td>{{$customer['total_order']}}</td>
                <td>{{$customer['total_cart']}}</td>
                <td>{{$customer['total_ticket']}}</td>
                <td>{{$customer['total_wallet']}}</td>
                <td>{{$customer['total_money']}}</td>
            </tr>
        @endforeach
    @endif

</table>
</body>
</body>
</html>
