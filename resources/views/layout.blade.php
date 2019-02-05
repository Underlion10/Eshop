@section('layout')
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/welcome.css')}}">
    <link rel="icon" href="{{asset('images/cart.ico')}}">
    <title>Laravel Bookstore</title>
</head>
<body class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container text-white">
            <a href="{{url('/')}}" class="navbar-brand" title="Home">
                <img src="{{asset('images/shoppingbag.png')}}" alt="Bolsa de compra" class="logo">
            </a>
            @if(session()->has('cart') && sizeof(session('cart')) > 0)
                <a href="{{url('/cart')}}" title="Shopping Cart">Shopping Cart</a>
            @endif
        </div>
    </nav>
    <div class="container bg-light static-left py-3">
            @if(isset($categories))
                <?php if(session()->has('cat')) $cat = session('cat'); else $cat = -1;?>
            <form action="{{url('/search')}}" method="post">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
                <label for="category" class="text-primary">Categoría</label>
                <select name="category" class="form-control-sm">
                    @foreach($categories as $category)
                        <option @if($category->category_id == $cat)
                                    selected
                                @endif
                                value="{{$category->category_id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
                <input class="btn btn-primary" type="submit" value="Buscar"/>
            </form>
            @endif
    </div>
    <p>Welcome to Laravel Bookstore</p>
@yield('body')
</body>
</html>
@show