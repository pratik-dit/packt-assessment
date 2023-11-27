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
use App\Http\Requests\UpdateBookRequest;
use App\Http\Requests\CreateBookRequest;

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

    public function destroy($bookId)
    {
      $book = Book::where('id', $bookId)->first();

      if($book != null){
        $book->delete();
      }

      return response()->json([
        'message' => 'Successfully removed book.',
        'status' => 200,
      ]);
    }

    public function show($bookId)
    {
      $book = Book::where('id', $bookId)->first();

      if($book == null){
        return response()->json([
          'message' => 'Book not found.',
          'status' => 401,
          'data' => null
        ]);
      }

      return response()->json([
        'message' => 'Successfully removed book.',
        'status' => 200,
        'data' => $book
      ]);
    }

    public function store(CreateBookRequest $request)
    {
      $user_id = Auth::user()->id;
      $data = $request->validated();
      $data['created_by'] = $user_id;
      $book = Book::create($data);
      return response()->json([
          'message'=>'Book Created Successfully!!',
          'status' => 200
      ]);
    }

    public function update(UpdateBookRequest $request, $bookId)
    {
      $book = Book::where('id', $bookId)->first();
      if($book == null){
        return response()->json([
          'message' => 'Book not found.',
          'status' => 401
        ]);
      }
      $book->update($request->validated());
      return response()->json([
        'message' => 'Successfully updated book.',
        'status' => 200
      ]);
    }
}