@extends('layout')
@section('body')
    <form action="{{url('/buy/confirm')}}" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <label for="delivery_name">Delivery Name</label>
        <input type="text" name="delivery_name" required>
        <label for="delivery_address">Delivery Address</label>
        <input type="text" name="delivery_address" required>
        <label for="cc_name">ccName</label>
        <input type="text" name="cc_name" required>
        <label for="cc_number">ccNumber</label>
        <input type="number" name="cc_number" required>
        <label for="cc_expiry">ccExpiry</label>
        <input type="text" name="cc_expiry" required>
        <input type="submit" name="buy" value="Make Payment">
    </form>
@endsection
