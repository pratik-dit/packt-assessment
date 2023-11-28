<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Book;
use MeiliSearch\Endpoints\Indexes;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $book = Book::search(trim($request->get('query')) ?? '', 
            function(Indexes $meiliSearch, string $query, array $options) use ($request) {
                if ($request->has('order_by')) {
                    $orderBy = explode(',', $request->order_by);
                    $options['sort'] = [$orderBy[0].':'.($orderBy[1] ?? 'asc')];
                }
                return $meiliSearch->search($query, $options);
            });

        return response()->json([
            'data' => $book->paginate(10),
            'status' => 200,
        ]);
    }
}