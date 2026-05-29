<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;

class BookController extends Controller
{
    public function __construct(
        private BookService $service
    )
    {
    }

    public function index()
    {
        return BookResource::collection(
            Book::with(['authors', 'genres', 'publisher'])->paginate()
        );
    }

    public function show(Book $book)
    {
        return new BookResource(
            $book->load(['authors', 'genres', 'publisher'])
        );
    }

    public function store(StoreBookRequest $request)
    {
        $book = $this->service->create(
            $request->validated()
        );

        return new BookResource(
            $book->load(['authors', 'genres', 'publisher'])
        );
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book = $this->service->update(
            $book,
            $request->validated()
        );

        return new BookResource(
            $book->load(['authors', 'genres', 'publisher'])
        );
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
