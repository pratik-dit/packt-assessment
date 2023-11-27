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

    public function getBooks()
    {
      $books = Book::orderBy('created_by', 'desc')->orderBy('id','desc')->paginate(10);
      $response = [
          'data' => $books
      ];
      return response()->json($response);
    }
}