<?php

declare(strict_types=1);

namespace AOC;

$ff = file_get_contents("day1a.txt");
$input = explode("\n", $ff);
sort($input, SORT_NUMERIC);

foreach ($input as $value) {
    $pair = 2020 - (int) $value;
    if (array_search($pair, $input) !== false) {
        echo $value * $pair, PHP_EOL;
        exit;
    }
}
