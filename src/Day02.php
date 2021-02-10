<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day02 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $ff = file_get_contents(__DIR__ . "/day2a.txt");

        $valid = 0;
        preg_match_all("/([0-9]+)-([0-9]+) ([a-z]): ([a-z]*)/", $ff, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            [$a, $min, $max, $char, $pass] = $match;
            preg_match_all("/{$char}/", $pass, $count);
            if (((int) $min <= count($count[0])) && ((int) $max >= count($count[0]))) {
                $valid++;
            }
        }

        $io->info((string) $valid);
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $ff = file_get_contents(__DIR__ . "/day2a.txt");

        $valid = 0;
        preg_match_all("/([0-9]+)-([0-9]+) ([a-z]): ([a-z]*)/", $ff, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            [$a, $first, $second, $char, $pass] = $match;
            $first = (int) $first - 1;
            $second = (int) $second - 1;
            if ((int) ($pass[$first] === $char) ^ (int) ($pass[$second] === $char)) {
                $valid++;
            }
        }

        $io->info((string) $valid);
    }
}
