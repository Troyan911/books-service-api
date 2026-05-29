<?php

namespace App\Support\Csv;

class CsvHelper
{
    public static function removeBom(string $value): string
    {
        return preg_replace('/^\xEF\xBB\xBF/', '', $value);
    }

    public static function normalizeValue(string $value): string
    {
        return self::removeBom(trim($value));
    }

    public static function normalizeHeader(array $header): array
    {
        return array_map(
            fn($h) => strtolower(self::normalizeValue($h)),
            $header
        );
    }

    public static function normalizeRow(array $row): array
    {
        return array_map(
            fn($value) => self::normalizeValue($value),
            $row
        );
    }
}
