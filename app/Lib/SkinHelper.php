<?php

namespace App\Lib;

class SkinHelper
{
    public static function getSkinUrl(string $nickname): ?string
    {
        $initialUrl = "http://skinsystem.ely.by/skins/" . urlencode($nickname) . "/";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $initialUrl);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        $response = curl_exec($ch);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode === 200 && str_ends_with($finalUrl, '.png')) {
            return $finalUrl;
        }

        return '/public/images/skins/steve.png';
    }
}