<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Book;
use Redirect,Response;
use App\Http\Controllers\Controller;

class BookController extends Controller
{

    public function __construct()
    {

    }

    public function getBooks(Request $request)
    {
      if($request->term != null){
        $term = $request->term;
        $books = Book::where(function ($query) use($term) {
                  $query->where('title', 'LIKE', "%$term%")
                        ->orWhere('author', 'LIKE', "%$term%")
                        ->orWhere('isbn', 'LIKE', "%$term%")
                        ->orWhere('genre', 'LIKE', "%$term%");
                })->orderBy('created_by', 'desc')->orderBy('id','desc')->paginate(10);
      }else {
        $books = Book::orderBy('created_by', 'desc')->orderBy('id','desc')->paginate(10);
      }
      $response = [
          'data' => $books
      ];
      return response()->json($response);
    }
}