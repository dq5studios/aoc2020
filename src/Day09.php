<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day09 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $stream = explode("\n", $this->input);

        $buffer = [];
        foreach ($stream as $value) {
            $length = array_push($buffer, (int) $value);
            if ($length <= 25) {
                continue;
            }
            if (!$this->isValid($buffer, (int) $value)) {
                $io->info($value);
            }
            array_shift($buffer);
        }
    }

    /**
     * @param int[] $buffer
     * @param int   $value
     *
     * @return bool
     */
    public function isValid(array $buffer, int $value): bool
    {
        foreach ($buffer as $first) {
            if (in_array($value - $first, $buffer)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $stream = explode("\n", $this->input);

        $sums = $this->scan($stream, 22477624);

        $total = min($sums) + max($sums);

        $io->info((string) $total);
    }

    /**
     * @param list<string> $stream
     * @param int          $target
     *
     * @return non-empty-list<int>
     */
    public function scan(array $stream, int $target): array
    {
        $buffer = [];
        foreach ($stream as $value) {
            if (!empty($buffer) && array_sum($buffer) === $target) {
                return $buffer;
            }
            array_push($buffer, (int) $value);
            while (array_sum($buffer) > $target) {
                array_shift($buffer);
            }
        }
        return [0];
    }
}
