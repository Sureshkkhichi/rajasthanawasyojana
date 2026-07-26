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

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $number = (float) $number;
        $no = floor($number);
        $point = round(($number - $no) * 100);
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $counter = count($str);
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : '';
                $str[] = ($number < 21) ? $words[$number] .
                    ' ' . $digits[$counter] . ' ' . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . ' ' . $words[$number % 10] . ' '
                    . $digits[$counter] . ' ' . $hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse(array_filter($str));
        $result = implode(' ', $str);
        $points = ($point) ?
            ' and ' . ($words[floor($point / 10) * 10] . ' ' . 
                $words[$point % 10]) . ' Paise' : '';
        return trim(preg_replace('/\s+/', ' ', $result)) . ' Rupees' . $points;
    }
}