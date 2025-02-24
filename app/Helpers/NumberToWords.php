<?php

if (!function_exists('number_to_words')) {
    function number_to_words($number)
    {
        $words = [
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
        ];

        if ($number < 12) {
            return $words[$number];
        } elseif ($number < 20) {
            return $words[$number - 10] . ' belas';
        } elseif ($number < 100) {
            return $words[floor($number / 10)] . ' puluh ' . $words[$number % 10];
        } elseif ($number < 200) {
            return 'seratus ' . number_to_words($number - 100);
        } elseif ($number < 1000) {
            return $words[floor($number / 100)] . ' ratus ' . number_to_words($number % 100);
        } elseif ($number < 2000) {
            return 'seribu ' . number_to_words($number - 1000);
        } elseif ($number < 1000000) {
            return number_to_words(floor($number / 1000)) . ' ribu ' . number_to_words($number % 1000);
        } elseif ($number < 1000000000) {
            return number_to_words(floor($number / 1000000)) . ' juta ' . number_to_words($number % 1000000);
        } elseif ($number < 1000000000000) {
            return number_to_words(floor($number / 1000000000)) . ' miliar ' . number_to_words($number % 1000000000);
        } elseif ($number < 100000000000000) {
            return number_to_words(floor($number / 1000000000000)) . ' triliun ' . number_to_words($number % 1000000000000);
        }

        return 'Angka terlalu besar';
    }
}

// Fungsi tambahan untuk menambahkan "RUPIAH" dan menangani kasus khusus
function format_rupiah_in_words($number)
{
    if ($number == 0) {
        return 'NOL RUPIAH';
    }

    $words = strtoupper(number_to_words($number));

    // Menghapus kata 'SATU' sebelum 'RIBU', 'JUTA', 'MILIAR', dan 'TRILIUN' jika ada
    $words = str_replace(['SATU RIBU'], ['SERIBU'], $words);

    // Menghapus 'NOLNOL', 'NOL RATUS', dll
    $words = preg_replace('/ NOL (RATUS|PULUH|BELAS)/', '', $words);
    $words = preg_replace('/ NOL/', '', $words);

    return trim($words) . ' RUPIAH';
}
