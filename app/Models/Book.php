<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Laravel\Scout\Searchable;

class Book extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'author',
        'genre',
        'description',
        'isbn',
        'image',
        'published',
        'publisher',
        'created_by',
    ];

    public function toSearchableArray(): array
    {
      return [
          'id' => $this->id,
          'title' => $this->title,
          'author' => $this->author,
          'genre' => $this->genre,
          'isbn' => $this->isbn,
          'published' => $this->published,
          'publisher' => $this->publisher
      ];
    }
}
