<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportBookRequest;
use App\Services\CsvImportService;

class BookImportController extends Controller
{
    public function import(ImportBookRequest $request)
    {
        $request->validated();

        $result = app(CsvImportService::class)
            ->import(
                $request->file('file')->getRealPath()
            );

        return response()->json($result);
    }
}
