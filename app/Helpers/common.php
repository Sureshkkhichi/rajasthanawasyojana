<?php

if (!function_exists('indianCurrency')) {
    function indianCurrency($amount)
    {
        return (new \NumberFormatter('en_IN', \NumberFormatter::DECIMAL))
            ->format((float) $amount);
    }
}