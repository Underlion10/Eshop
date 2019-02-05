@extends('layout')
@section('body')
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Identifier</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Price</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php $total = 0?>
            @foreach(session('cart') as $elem)
                <tr>
                    <form action="{{url('update/' . $elem['id'])}}" method="post">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
                    <?php $total += ($elem['price'] * $elem['amount']) ?>
                    @foreach($elem as $k => $v)
                        @if($k === 'id') <th scope="row"> @else <td> @endif
                        @if($k === 'amount')
                        <input type="number"
                               name="{{$k}}"
                               value="{{$v}}" min="1" required>
                        @else
                            {{$v}}
                        @endif
                        @if($k === 'id') </th> @else </td> @endif
                    @endforeach
                    <td>
                        <input type="submit" class="btn btn-primary" name="update" value="Update"/>
                        <input type="submit" class="btn btn-danger" name="delete" value="Delete"/>
                    </td>
                    </form>
                </tr>
            @endforeach
                <tr>
                    <td colspan="2">Total</td>
                    <td>{{$total}} €</td>
                    <td><a href="{{url('/buy')}}">Buy</a></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection