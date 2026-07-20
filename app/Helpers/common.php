<?php

if (!function_exists('indianCurrency')) {
    function indianCurrency($amount)
    {
        return (new \NumberFormatter('en_IN', \NumberFormatter::DECIMAL))
            ->format((float) $amount);
    }
}

if (!function_exists('reshapeDevanagari')) {
    function reshapeDevanagari($text)
    {
        if (empty($text)) {
            return $text;
        }
        // Reorder short "i" matra (ि) (U+093F) to be before the consonant it modifies.
        $pattern = '/((?:[\x{0915}-\x{0939}]\x{094d})*[\x{0915}-\x{0939}])\x{093f}/u';
        return preg_replace($pattern, 'ि$1', $text);
    }
}