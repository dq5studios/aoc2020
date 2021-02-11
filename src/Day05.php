<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day05 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $tickets = explode("\n", $this->input);

        $max = 0;
        foreach ($tickets as $seat) {
            $row = [0, 127];
            $col = [0, 7];
            $parts = str_split($seat);
            foreach ($parts as $move) {
                $jump_r = floor((($row[1] - $row[0]) + 1) / 2);
                $jump_c = floor((($col[1] - $col[0]) + 1) / 2);
                switch ($move) {
                    case "F":
                        $row[1] -= $jump_r;
                        break;
                    case "B":
                        $row[0] += $jump_r;
                        break;
                    case "L":
                        $col[1] -= $jump_c;
                        break;
                    case "R":
                        $col[0] += $jump_c;
                        break;
                }
            }
            $seat_id = $row[0] * 8 + $col[0];
            $max = max([$max, $seat_id]);
        }

        $io->info((string) $max);
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $tickets = explode("\n", $this->input);

        $airplane = array_fill(8, 126 * 8 + 7, true);
        $max = 0;
        foreach ($tickets as $seat) {
            $row = [0, 127];
            $col = [0, 7];
            $parts = str_split($seat);
            foreach ($parts as $move) {
                $jump_r = floor((($row[1] - $row[0]) + 1) / 2);
                $jump_c = floor((($col[1] - $col[0]) + 1) / 2);
                switch ($move) {
                    case "F":
                        $row[1] -= $jump_r;
                        break;
                    case "B":
                        $row[0] += $jump_r;
                        break;
                    case "L":
                        $col[1] -= $jump_c;
                        break;
                    case "R":
                        $col[0] += $jump_c;
                        break;
                }
            }
            $seat_id = $row[0] * 8 + $col[0];
            unset($airplane[$seat_id]);
        }

        $io->info((string) min(array_keys($airplane) ?: [9999]));
    }
}
