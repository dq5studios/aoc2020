<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Exception;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day08 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $program = explode("\n", $this->input);

        $history = [];

        $exit = false;
        $reg_a = 0;
        $cnt = 0;
        do {
            preg_match('/([a-z]+) ([-+][0-9]+)/', $program[$cnt], $parts);
            [, $cmd, $val] = $parts;
            switch ($cmd) {
                case "acc":
                    $reg_a += (int) $val;
                    $cnt++;
                    break;
                case "jmp":
                    $cnt += (int) $val;
                    break;
                case "nop":
                    $cnt++;
                    break;
            }
            $exit = (in_array($cnt, $history));
            $history[] = $cnt;
        } while (!$exit);

        $io->info((string) $reg_a);
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $program = explode("\n", $this->input);

        $reg_a = -1 ;
        foreach ($program as $line => $command) {
            $program[$line] = str_replace(["jmp", "nop"], ["pon", "pmj"], $command);
            $program[$line] = str_replace(["pon", "pmj"], ["nop", "jmp"], $program[$line]);
            try {
                $reg_a = $this->runProgram($program);
                $io->info((string) $reg_a);
                exit;
            } catch (Exception) {
            }
            $program[$line] = $command;
        }
    }

    /**
     * @param array<int,string> $program
     *
     * @return int
     */
    public function runProgram(array $program): int
    {
        $history = [];

        $exit = false;
        $reg_a = 0;
        $cnt = 0;
        do {
            if (empty(trim($program[$cnt]))) {
                return $reg_a;
            }
            preg_match('/([a-z]+) ([-+][0-9]+)/', $program[$cnt], $parts);
            [, $cmd, $val] = $parts;
            switch ($cmd) {
                case "acc":
                    $reg_a += (int) $val;
                    $cnt++;
                    break;
                case "jmp":
                    $cnt += (int) $val;
                    break;
                case "nop":
                    $cnt++;
                    break;
            }
            if ($cnt >= count($program)) {
                return $reg_a;
            }
            if (in_array($cnt, $history)) {
                throw new Exception();
            }
            $history[] = $cnt;
        } while (!$exit);

        return $reg_a;
    }
}
