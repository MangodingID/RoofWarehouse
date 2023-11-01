<?php

/**
 * @return string[]
 */
function months() : array
{
    return [
        '1'  => 'Januari',
        '2'  => 'Februari',
        '3'  => 'Maret',
        '4'  => 'April',
        '5'  => 'Mei',
        '6'  => 'Juni',
        '7'  => 'Juli',
        '8'  => 'Agustus',
        '9'  => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];
}

/**
 * @param  string $month
 * @return string
 */
function month(string $month) : string
{
    return months()[$month] ?? $month;
}

/**
 * @param  mixed $amount
 * @return string
 */
function format_money(mixed $amount) : string
{
    return 'Rp ' . format_number($amount);
}

/**
 * @param  mixed $value
 * @return string
 */
function format_number(mixed $value) : string
{
    if (! is_numeric($value)) {
        return $value;
    }

    return number_format($value, 0, ',', '.');
}
