<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FakerApiService;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Carbon\Carbon;

class SyncFakerBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
      // 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FakerApiService $apiService)
    {
        $fakerBooks = $apiService->getBooks(100);
        // Delete and Insert except admin created
        Book::whereNull('created_by')->delete();
        $data = [];
        $todayDate = Carbon::now();
        foreach($fakerBooks->data as $fakerBook){
          $data[] = [
            'title'=> $fakerBook->title,
            'author'=> $fakerBook->author,
            'genre'=> $fakerBook->genre,
            'description'=> $fakerBook->description,
            'isbn'=> $fakerBook->isbn,
            'image'=> $fakerBook->image,
            'published'=> $fakerBook->published,
            'publisher'=> $fakerBook->publisher,
            'created_at'=> $todayDate,
            'updated_at'=> $todayDate,
          ];
        }
        Book::insert($data);
    }
}
