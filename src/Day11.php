<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day11 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $now = explode("\n", $this->input);
        $now = array_map(fn(string $x) => str_split($x), $now);

        do {
            $past = $now;
            $now = $this->fillSeats($now);
            $now = $this->emptySeats($now);

            $lines = array_map(fn(array $x) => implode("", $x), $now);
            $now_diff = implode("", $lines);
            $lines = array_map(fn(array $x) => implode("", $x), $past);
            $past_diff = implode("", $lines);

            $exit = strcmp($now_diff, $past_diff);
        } while ($exit !== 0);

        $occupied = $this->countOccupied($now);
        $io->info((string) $occupied);
    }

    /**
     * @param array<int,array<int,string>> $now
     *
     * @return array<int,array<int,string>>
     */
    public function fillSeats(array $now): array
    {
        $future = $now;
        foreach ($now as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($cell !== "L") {
                    continue;
                }
                $n = $this->countNeighbors($now, $i, $j);
                if ($n === 0) {
                    $future[$i][$j] = "#";
                }
            }
        }

        return $future;
    }

    /**
     * @param array<int,array<int,string>> $now
     *
     * @return array<int,array<int,string>>
     */
    public function emptySeats(array $now): array
    {
        $future = $now;
        foreach ($now as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($cell !== "#") {
                    continue;
                }
                $n = $this->countNeighbors($now, $i, $j);
                if ($n >= 4) {
                    $future[$i][$j] = "L";
                }
            }
        }

        return $future;
    }

    /**
     * @param array<int,array<int,string>> $grid
     * @param int               $row
     * @param int               $col
     *
     * @return int
     */
    public function countNeighbors(array $grid, int $row, int $col): int
    {
        $count = 0;
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                if ($i === 0 && $j === 0) {
                    continue;
                }
                $cell = $grid[$row + $i][$col + $j] ?? ".";
                $count += ($cell === "#") ? 1 : 0;
            }
        }
        return $count;
    }

    /**
     * @param array<int,array<int,string>> $grid
     *
     * @return int
     */
    public function countOccupied(array $grid): int
    {
        $lines = array_map(fn(array $x) => implode("", $x), $grid);
        $line = implode("", $lines);
        preg_match_all("/#/", $line, $matches);
        return count($matches[0]);
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $now = explode("\n", $this->input);
        $now = array_map(fn(string $x) => str_split($x), $now);

        do {
            $past = $now;
            $now = $this->fillFarSeats($now);
            $now = $this->emptyFarSeats($now);

            $lines = array_map(fn(array $x) => implode("", $x), $now);
            $now_diff = implode("", $lines);
            $lines = array_map(fn(array $x) => implode("", $x), $past);
            $past_diff = implode("", $lines);

            $exit = strcmp($now_diff, $past_diff);
        } while ($exit !== 0);

        $occupied = $this->countOccupied($now);
        $io->info((string) $occupied);
    }

    /**
     * @param array<int,array<int,string>> $grid
     * @param int               $row
     * @param int               $col
     *
     * @return int
     */
    public function countFarNeighbors(array $grid, int $row, int $col): int
    {
        $count = 0;
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                if ($i === 0 && $j === 0) {
                    continue;
                }
                $m = 1;
                do {
                    $cell = $grid[$row + ($i * $m)][$col + ($j * $m)] ?? "X";
                    $m++;
                } while ($cell === ".");
                $count += ($cell === "#") ? 1 : 0;
            }
        }
        return $count;
    }

    /**
     * @param array<int,array<int,string>> $now
     *
     * @return array<int,array<int,string>>
     */
    public function fillFarSeats(array $now): array
    {
        $future = $now;
        foreach ($now as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($cell !== "L") {
                    continue;
                }
                $n = $this->countFarNeighbors($now, $i, $j);
                if ($n === 0) {
                    $future[$i][$j] = "#";
                }
            }
        }

        return $future;
    }

    /**
     * @param array<int,array<int,string>> $now
     *
     * @return array<int,array<int,string>>
     */
    public function emptyFarSeats(array $now): array
    {
        $future = $now;
        foreach ($now as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($cell !== "#") {
                    continue;
                }
                $n = $this->countFarNeighbors($now, $i, $j);
                if ($n >= 5) {
                    $future[$i][$j] = "L";
                }
            }
        }

        return $future;
    }
}
