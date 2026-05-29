<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function create(array $data): Book
    {
        return DB::transaction(function () use ($data) {

            $book = $this->createBook($data);

            $this->syncPublisher($book, $data);
            $this->syncAuthors($book, $data);
            $this->syncGenres($book, $data);

            return $book;
        });
    }

    public function update(Book $book, array $data): Book
    {
        return DB::transaction(function () use ($book, $data) {

            $book->update($this->mapBookData($data));

            $this->syncPublisher($book, $data);
            $this->syncAuthors($book, $data);
            $this->syncGenres($book, $data);

            return $book;
        });
    }

    /**
     * Core book fields only
     */
    private function mapBookData(array $data): array
    {
        return collect($data)
            ->only([
                'title',
                'description',
                'edition',
                'published_at',
                'format',
                'pages',
                'country',
                'isbn',
            ])
            ->toArray();
    }

    private function createBook(array $data): Book
    {
        return Book::create(
            $this->mapBookData($data)
        );
    }

    private function syncPublisher(Book $book, array $data): void
    {
        if (!isset($data['publisher'])) {
            return;
        }

        $publisher = Publisher::firstOrCreate([
            'name' => $data['publisher']
        ]);

        $book->update([
            'publisher_id' => $publisher->id
        ]);
    }

    private function syncAuthors(Book $book, array $data): void
    {
        if (empty($data['authors'])) {
            return;
        }

        $authorIds = collect($data['authors'])
            ->filter()
            ->map(fn($name) => Author::firstOrCreate(['name' => trim($name)])->id
            )
            ->values()
            ->toArray();

        $book->authors()->sync($authorIds);
    }

    private function syncGenres(Book $book, array $data): void
    {
        if (empty($data['genres'])) {
            return;
        }

        $genreIds = collect($data['genres'])
            ->filter()
            ->map(fn($name) => Genre::firstOrCreate(['name' => trim($name)])->id
            )
            ->values()
            ->toArray();

        $book->genres()->sync($genreIds);
    }
}
