<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day01 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $input = explode("\n", $this->input);
        sort($input, SORT_NUMERIC);

        foreach ($input as $value) {
            $pair = 2020 - (int) $value;
            if (array_search($pair, $input) !== false) {
                $io->info((string) ((int) $value * $pair));
                return;
            }
        }
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $input = explode("\n", $this->input);
        sort($input, SORT_NUMERIC);

        foreach ($input as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $pair = 2020 - (int) $value;
            $middle = $this->findPair($input, $pair);
            if (!is_null($middle)) {
                $third = 2020 - (int) $value - $middle;
                $io->info((string) ((int) $value * $middle * $third));
                return;
            }
        }
    }

    /**
     * @param string[] $input
     * @param int      $sum
     *
     * @return int|null
     */
    public function findPair(array $input, int $sum): ?int
    {
        foreach ($input as $value) {
            $pair = $sum - (int) $value;
            if (array_search($pair, $input) !== false) {
                return (int) $value;
            }
        }
        return null;
    }
}
