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
    public static function generatePagination(int $currentPage, int $totalPages, string $baseUrl): array
    {
        $links = [];
        $start = max(1, $currentPage - 2);
        $end = min($start + 4, $totalPages);

        if ($currentPage > 1) {
            $links[] = ['page' => 1, 'text' => '<<', 'url' => "{$baseUrl}1"];
            $links[] = ['page' => $currentPage - 1, 'text' => '<', 'url' => "{$baseUrl}" . ($currentPage - 1)];
        }

        for ($i = $start; $i <= $end; $i++) {
            $links[] = [
                'page' => $i,
                'text' => (string)$i,
                'active' => ($i == $currentPage),
                'url' => "{$baseUrl}{$i}"
            ];
        }

        if ($currentPage < $totalPages) {
            $links[] = ['page' => $currentPage + 1, 'text' => '>', 'url' => "{$baseUrl}" . ($currentPage + 1)];
            $links[] = ['page' => $totalPages, 'text' => '>>', 'url' => "{$baseUrl}{$totalPages}"];
        }

        return $links;
    }
    public static function slugify(string $text): string
    {
        $translit = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', ' ' => '-',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'U' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya', ' ' => '-'
        ];

        $text = strtr($text, $translit);
        $text = preg_replace('/[^a-z0-9-]+/i', '', $text);
        $text = strtolower(trim($text, '-'));

        return $text;
    }
}
