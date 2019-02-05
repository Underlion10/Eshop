<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\Order;
use App\Order_Detail;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class BookController extends Controller
{
    public function show(Request $request){
        $cat = $request->input('category');
        session(['cat' => $cat]);
        $books = Book::where('category_id', '=', $cat)->get();
        return redirect()->to('/')->with('books', $books);
    }

    public function store(Request $request, $id){
        $book = Book::where('book_id', '=', $id)->first();
        if(session()->has('cart')){
            $cart = session('cart');
            if(isset($cart[$id])){
                $cart[$id]['amount']++;
                $cart[$id]['subtotal'] += $cart[$id]['price'];
            } else {
                $cart[$id] = [
                  'id' => $book->book_id,
                  'title' => $book->title,
                  'author' => $book->author,
                  'price' => $book->price,
                  'amount' => 1,
                  'subtotal' => $book->price
                ];
            }
        } else {
            $cart = [$id => [
                'id' => $book->book_id,
                'title' => $book->title,
                'author' => $book->author,
                'price' => $book->price,
                'amount' => 1,
                'subtotal' => $book->price
            ]];
        }
        $request->session()->put('cart', $cart);
        return redirect()->to('/cart');
    }

    public function update(Request $request, $id){
        if(session()->has('cart')) {
            $cart = session('cart');
            if ($request->has('update')) {
                $cart[$id]['amount'] = $request->input('amount');
            }
            else if($request->has('delete')){
                unset($cart[$id]);
                if(sizeof($cart) === 0){
                    $request->session()->put('cart', $cart);
                    return redirect()->to('/');
                }
            }
            $request->session()->put('cart', $cart);
            return redirect()->to('/cart');
        } else {
            abort(404);
        }
    }

    public function buy(){
        if(session()->has('cart')){
            return view('buy');
        } else {
            abort(404);
        }
    }

    public function confirm(Request $request){
        if(session()->has('cart')){
            $order = new Order;
            try {
                $order['order_id'] = random_int(1000000000000, 9900000000000);
                $order['delivery_name'] = htmlspecialchars($request->input('delivery_name'));
                $order['delivery_address'] = htmlspecialchars($request->input('delivery_address'));
                $order['cc_name'] = htmlspecialchars($request->input('cc_name'));
                $order['cc_number'] = htmlspecialchars($request->input('cc_number'));
                $order['cc_expiry'] = htmlspecialchars($request->input('cc_expiry'));
                $order->save();
            } catch (\Exception $e) {
                return redirect()->back();
            }
            $cart = session('cart');
            foreach($cart as $id => $book){
                $order_detail = new Order_Detail;
                $order_detail['order_id'] = $order['order_id'];
                $order_detail['book_id'] = $id;
                $order_detail['amount'] = $book['amount'];
                $order_detail->save();
            }
            session()->remove('cart');
            return redirect()->to('/')->with('message', 'Congratulations, your purchase has been finished!');
        } else {
            abort(404);
        }
    }
}
