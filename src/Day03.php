<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day03 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $ff = file_get_contents(__DIR__ . "/day3a.txt");

        $map = explode("\n", $ff);

        $trees = (string) $this->shift($map, 3, 1);

        $io->info($trees);
    }

    /**
     * @param string[] $map
     * @param int      $offset
     *
     * @return int
     */
    public function shift(array $map, int $offset, int $rc): int
    {
        $x = 0;
        $trees = 0;
        $count = count($map);
        for ($i = 0; $i < $count; $i += $rc) {
            if (empty($map[$i])) {
                continue;
            }
            if ($map[$i][$x] === "#") {
                $trees++;
            }
            $x += $offset;
            if ($x >= strlen($map[$i])) {
                $x = $x % strlen($map[$i]);
            }
        }

        return $trees;
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $ff = file_get_contents(__DIR__ . "/day3a.txt");

        $map = explode("\n", $ff);

        $multi = [
            [1, 1],
            [3, 1],
            [5, 1],
            [7, 1],
            [1, 2],
        ];

        $trees = 1;
        foreach ($multi as $value) {
            $trees *= $this->shift($map, $value[0], $value[1]);
        }

        $io->info((string) $trees);
    }
}
