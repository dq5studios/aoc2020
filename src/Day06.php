<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day06 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $quiz = explode("\n\n", $this->input);

        $total = 0;
        foreach ($quiz as $answer) {
            $answer = str_replace("\n", "", $answer);
            $total += count(array_unique(str_split($answer)));
        }

        $io->info((string) $total);
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $quiz = explode("\n\n", $this->input);

        $total = 0;
        foreach ($quiz as $answer) {
            $answer = explode("\n", $answer);
            $answer = array_filter($answer, fn(string $x): bool => !empty($x));
            $splits = array_map(fn(string $x): array => str_split($x), $answer);
            $splits = array_map(fn(array $x): array => array_unique($x), $splits);
            $total += count(array_intersect(...$splits));
        }

        $io->info((string) $total);
    }
}
