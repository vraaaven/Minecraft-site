<?php

namespace App\Lib;

class Helper
{
    public static function formateDate($data): array | string
    {
        $month = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря'
        ];
        if (is_array($data)) {
            foreach ($data as $value) {
                $timestamp = strtotime($value->getField('date'));
                $year = date('Y', $timestamp) != date('Y') ? date('Y', $timestamp) : "";
                $formattedDate = date('d', $timestamp) . ' ' . $month[date('n', $timestamp)] . ' ' . $year;
                $value->setField('date', $formattedDate);
            }
            return $data;
        }
        $timestamp = strtotime($data);
        $year = date('Y', $timestamp) != date('Y') ? date('Y', $timestamp) : "";
        return date('d', $timestamp) . ' ' . $month[date('n', $timestamp)] . ' ' . $year;
    }
    public static function extractSentences($text, $numSentences) {
        $sentences = preg_split('/(?<=[.?!])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $extractedSentences = array_slice($sentences, 0, $numSentences);
        return implode(' ', $extractedSentences);
    }

    public static function closeWithError(string $str): void
    {
        die('<div style="background-color: #f44336; color: #fff; padding: 10px;">' . $str . '</div>');
    }

    public static function showError(string $str): string
    {
        return '<div style="background-color: #f44336; color: #fff; padding: 10px;">' . $str . '</div>';
    }
    public static function generatePagination($currentPage, $totalPages): array
    {
        $links = [];
        $start = max(1, $currentPage - 2);
        $end = min($start + 4, $totalPages);
        for ($i = $start; $i <= $end; $i++) {
            $active = $i == $currentPage;
            $links[] = [
                'page' => $i,
                'active' => $active
            ];
        }
        return $links;
    }
}
