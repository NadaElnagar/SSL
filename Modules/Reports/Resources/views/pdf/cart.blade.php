<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ 'Cart Report' }}</title>
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
<h2>{{ 'Cart Report'}}
<span style="float: right">{{'Total Cart: '.$data['total_cart']}}</span>
</h2>
<table width="99%" style="width:100%" border=".5">
    <tr>
        <td><h4>user mail</h4></td>
        <td><h4>Cart Quantity</h4></td>
        <td><h4>Start Cart Date</h4></td>
        <td><h4>Last Cart Update</h4></td>
        <td><h4>Certificate Name</h4></td>
        <td><h4>Certificate Number Months</h4></td>
        <td><h4>Certificate Price</h4></td>
    </tr>
    @if($data)
        @foreach($data['cart'] as $cart)
            <tr>
                <td>{{$cart['user']['email']}}</td>
                <td>{{$cart->Quantity}}</td>
                <td>{{$cart->start_cart}}</td>
                <td>{{$cart->last_update}}</td>
                <td colspan="3"></td>
                @if($cart['user_cart_details'] )
        @foreach($cart['user_cart_details'] as $details)
            </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>{{$details['product_name']}}</td>
                    <td>{{$details['product_price']['number_of_months']}}</td>
                    <td>{{$details['product_price']['price']}}</td>
                </tr>
            @endforeach
        @else
            </tr>
                @endif

        @endforeach
    @endif

</table>
</body>
</body>
</html>
