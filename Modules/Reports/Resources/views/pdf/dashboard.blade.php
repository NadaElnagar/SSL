<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ 'DashBoard Report' }}</title>
</head>
<body>
<h2>{{ 'Dashboard Report'}}</h2>
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
        <td><h3>Total Order</h3></td>
        <td><h3>Total Payment</h3></td>
        <td><h3>Total Product</h3></td>
        <td><h3>Total Inactive Product</h3></td>
        <td><h3>Total active Product</h3></td>
        <td><h3>Total Users</h3></td>
        <td><h3>Total Category</h3></td>
        <td><h3>Total Brand</h3></td>
    </tr>
    <tr>
        <td>{{$data['total_orders']}}</td>
        <td>{{$data['total_payment']}}</td>
        <td>{{$data['total_product']}}</td>
        <td>{{$data['total_inactive_product']}}</td>
        <td>{{$data['total_active_product']}}</td>
        <td>{{$data['total_users']}}</td>
        <td>{{$data['total_category']}}</td>
        <td>{{$data['total_brand']}}</td>

    </tr>
</table>
</body>
</body>
</html>
