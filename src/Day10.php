<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day10 extends Command
{
    /** @var array<int,int> $i_know_this */
    public array $i_know_this = [];

    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $adapters = explode("\n", $this->input);

        $ones = 0;
        $threes = 0;
        $adapters = array_map(fn(string $x) => (int) $x, $adapters);
        $device = max($adapters) + 3;
        sort($adapters);
        $adapters[] = $device;
        $cable = 0;
        do {
            if (in_array($cable + 1, $adapters)) {
                $ones++;
                $cable += 1;
            } elseif (in_array($cable + 2, $adapters)) {
                $cable += 2;
            } elseif (in_array($cable + 3, $adapters)) {
                $threes++;
                $cable += 3;
            } else {
                $io->error("Failed at {$cable}");
                return;
            }
        } while ($cable < $device);

        $io->info((string) ($ones * $threes));
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $adapters = explode("\n", $this->input);
        $adapters = array_map(fn(string $x) => (int) $x, $adapters);
        $device = max($adapters) + 3;
        sort($adapters);
        $adapters[] = $device;

        $total = $this->countValid($adapters, 0);

        $io->info((string) $total);
    }

    /**
     * @param non-empty-list<int> $adapters
     * @param int                 $current
     *
     * @return int
     */
    public function countValid(array $adapters, int $current): int
    {
        if ($current === max($adapters)) {
            return 1;
        }
        if (isset($this->i_know_this[$current])) {
            return $this->i_know_this[$current];
        }

        $count = 0;
        if (in_array($current + 1, $adapters)) {
            $count += $this->countValid($adapters, $current + 1);
        }
        if (in_array($current + 2, $adapters)) {
            $count += $this->countValid($adapters, $current + 2);
        }
        if (in_array($current + 3, $adapters)) {
            $count += $this->countValid($adapters, $current + 3);
        }
        $this->i_know_this[$current] = $count;
        return $count;
    }
}
