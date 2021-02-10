<?php

declare(strict_types=1);

namespace AOC;

$ff = file_get_contents("day1a.txt");
$input = explode("\n", $ff);
sort($input, SORT_NUMERIC);

function findPair(array $input, int $sum): ?int
{
    foreach ($input as $value) {
        $pair = $sum - (int) $value;
        if (array_search($pair, $input) !== false) {
            return (int) $value;
        }
    }
    return null;
}

foreach ($input as $key => $value) {
    if (empty($value)) {
        continue;
    }
    $pair = 2020 - (int) $value;
    $middle = findPair($input, $pair);
    if (!is_null($middle)) {
        $third = 2020 - (int) $value - $middle;
        echo $value, " ", $middle, " ", $third, PHP_EOL;
        echo (int) $value * $middle * $third, PHP_EOL;
        exit;
    }
}
