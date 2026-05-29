<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
        'edition',
        'published_at',
        'format',
        'pages',
        'country',
        'isbn',
        'publisher_id',
    ];

    protected $casts = [
        'published_at' => 'date',
        'pages' => 'integer',
        'edition' => 'integer',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
