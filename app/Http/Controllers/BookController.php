<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use App\Jobs\SyncFakerBooks;
use Carbon\Carbon;

class BookController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function syncFakerBooksData()
    {
        SyncFakerBooks::dispatchNow();

        return response()->json([
          'message' => 'Successfully syced books.',
          'status' => 200,
        ]);
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