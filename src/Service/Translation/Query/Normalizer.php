<?php

namespace App\Service\Translation\Query;

class Normalizer
{
    /**
     * @param string $query
     * @return string
     */
    public static function normalize(string $query): string
    {
        $text = mb_convert_case($query, MB_CASE_LOWER, "UTF-8");
        $text = preg_replace("#\s+#s", " ", $text);
        $text = preg_replace("#([\d\s]+)$#s", "", $text);
        $text = trim($text);
        $words = explode(' ', $text);
        $words = array_unique($words);
        $text = implode(' ', $words);
        return $text;
    }
}
