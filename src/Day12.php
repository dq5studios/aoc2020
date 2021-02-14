<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day12 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $commands = explode("\n", $this->input);

        $ship = new class () {
            public int $x = 0;
            public int $y = 0;
            public int $d = 90;
        };
        foreach ($commands as $order) {
            if (empty($order)) {
                continue;
            }
            preg_match("/([A-Z])([0-9]+)/", $order, $matches);
            [, $cmd, $val] = $matches;
            switch ($cmd) {
                case "N":
                    $ship->y -= (int) $val;
                    break;
                case "S":
                    $ship->y += (int) $val;
                    break;
                case "E":
                    $ship->x -= (int) $val;
                    break;
                case "W":
                    $ship->x += (int) $val;
                    break;
                case "L":
                    $ship->d = (($ship->d - (int) $val) + 360) % 360;
                    break;
                case "R":
                    $ship->d = (($ship->d + (int) $val) + 360) % 360;
                    break;
                case "F":
                    switch ($ship->d) {
                        case 0:
                            $ship->y -= (int) $val;
                            break;
                        case 90:
                            $ship->x -= (int) $val;
                            break;
                        case 180:
                            $ship->y += (int) $val;
                            break;
                        case 270:
                            $ship->x += (int) $val;
                            break;
                        default:
                            echo $ship->d;
                    }
                    break;
            }
        }

        $io->info((string) (abs($ship->x) + abs($ship->y)));
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $commands = explode("\n", $this->input);

        $ship = new class () {
            public int $x = 0;
            public int $y = 0;
        };
        $waypoint = new class () {
            public int $x = 10;
            public int $y = 1;
        };
        foreach ($commands as $order) {
            if (empty($order)) {
                continue;
            }
            preg_match("/([A-Z])([0-9]+)/", $order, $matches);
            [, $cmd, $val] = $matches;
            switch ($cmd) {
                case "N":
                    $waypoint->y += (int) $val;
                    break;
                case "S":
                    $waypoint->y -= (int) $val;
                    break;
                case "E":
                    $waypoint->x += (int) $val;
                    break;
                case "W":
                    $waypoint->x -= (int) $val;
                    break;
                case "L":
                    switch ((int) $val) {
                        case 90:
                            [$waypoint->x, $waypoint->y] = [-$waypoint->y, $waypoint->x];
                            break;
                        case 180:
                            [$waypoint->x, $waypoint->y] = [-$waypoint->x, -$waypoint->y];
                            break;
                        case 270:
                            [$waypoint->x, $waypoint->y] = [$waypoint->y, -$waypoint->x];
                            break;
                    }
                    break;
                case "R":
                    switch ((int) $val) {
                        case 90:
                            [$waypoint->x, $waypoint->y] = [$waypoint->y, -$waypoint->x];
                            break;
                        case 180:
                            [$waypoint->x, $waypoint->y] = [-$waypoint->x, -$waypoint->y];
                            break;
                        case 270:
                            [$waypoint->x, $waypoint->y] = [-$waypoint->y, $waypoint->x];
                            break;
                    }
                    break;
                case "F":
                    $times = (int) $val;
                    $ship->x += $waypoint->x * $times;
                    $ship->y += $waypoint->y * $times;
                    break;
            }
        }

        $io->info((string) (abs($ship->x) + abs($ship->y)));
    }
}
