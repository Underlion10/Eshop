@extends('layout')
@section('body')
    @if(session()->has('message'))
        <p class="text-success">{{session('message')}}</p>
    @endif
    @if(session()->has('books'))
        <table>
            @foreach(session('books') as $book)
                <tr>
                    <td>{{$book->title}}</td>
                    <td>{{$book->author}}</td>
                    <td>${{$book->price}}</td>
                    <td><a href="{{url('add/' . $book->book_id)}}">Add to cart</a></td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection