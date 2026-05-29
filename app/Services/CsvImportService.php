<?php

namespace App\Services;

use App\Support\Csv\CsvHelper;
use Illuminate\Support\Facades\DB;

class CsvImportService
{
    public function __construct(
        private BookService $bookService
    )
    {
    }

    public function import(string $path): array
    {
        $imported = 0;
        $skipped = 0;
        $failed = 0;

        $handle = fopen($path, 'r');

        $header = CsvHelper::normalizeHeader(
            fgetcsv($handle)
        );

        while (($row = fgetcsv($handle)) !== false) {
            try {
                $row = CsvHelper::normalizeRow($row);
                $data = array_combine($header, $row);

                // optional: skip empty rows
                if (!$data || empty($data['title'])) {
                    $skipped++;
                    continue;
                }

                // map CSV → domain format
                $bookData = $this->mapCsvToBookData($data);

                DB::transaction(function () use ($bookData, &$imported) {

                    $this->bookService->create($bookData);

                    $imported++;
                });

            } catch (\Throwable $e) {
                $failed++;

                logger()->error('CSV import error', [
                    'error' => $e->getMessage(),
                    'row' => $row ?? null,
                ]);
            }
        }

        fclose($handle);

        return [
            'imported' => $imported,
            'skipped' => $skipped,
            'failed' => $failed,
        ];
    }

    /**
     * CSV → Domain mapping layer
     */
    private function mapCsvToBookData(array $data): array
    {
        return [
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,

            'edition' => isset($data['edition'])
                ? (int)$data['edition']
                : null,

            'published_at' => $this->parseDate($data['year'] ?? null),

            'format' => $data['format'] ?? null,
            'pages' => isset($data['pages']) ? (int)$data['pages'] : null,
            'country' => $data['country'] ?? null,
            'isbn' => $data['isbn'] ?? null,

            'publisher' => $data['publisher'] ?? null,

            'authors' => isset($data['authors'])
                ? array_map('trim', explode(';', $data['authors']))
                : [],

            'genres' => isset($data['genre'])
                ? array_map('trim', explode(';', $data['genre']))
                : [],
        ];
    }

    private function parseDate(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        try {
            return \Carbon\Carbon::createFromFormat('d.m.Y', $value)
                ->toDateString();
        } catch (\Throwable) {
            return $value; // fallback: already Y-m-d
        }
    }
}
