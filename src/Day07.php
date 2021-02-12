<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day07 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $rules = explode("\n", $this->input);

        $rule_list = [];
        foreach ($rules as $rule) {
            if (empty($rule)) {
                continue;
            }

            [$bag, $contents] = explode(" bags contain ", $rule);
            preg_match_all('/([0-9]+) ([a-z ]+) bags?/', $contents, $matches);
            $rule_list[$bag] = $matches[2];
        }

        $matched = $this->whatHolds($rule_list, "shiny gold");
        $count = count($matched);

        $io->info((string) $count);
    }

    /**
     * @param array<string,list<string>> $list
     * @param string                     $color
     *
     * @return array<int,string>
     */
    public function whatHolds(array $list, string $color): array
    {
        if ($color === "no other") {
            return [];
        }

        $contains = [];
        foreach ($list as $outer => $inner) {
            if (in_array($color, $inner)) {
                $contains[] = $outer;
            }
        }
        $extra = $contains;
        foreach ($contains as $inner) {
            $more = $this->whatHolds($list, $inner);
            $extra = array_merge($extra, $more);
        }
        $final = array_unique($extra);
        return $final;
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $rules = explode("\n", $this->input);

        $rule_list = [];
        foreach ($rules as $rule) {
            if (empty($rule)) {
                continue;
            }

            [$bag, $contents] = explode(" bags contain ", $rule);
            preg_match_all('/([0-9]+) ([a-z ]+) bags?/', $contents, $matches);
            $rule_list[$bag] = $matches;
        }

        $count = $this->holdCount($rule_list, "shiny gold");

        $io->info((string) $count);
    }

    /**
     * @param array<string,array<array-key,list<string>>> $list
     * @param string                                      $color
     *
     * @return int
     */
    public function holdCount(array $list, string $color): int
    {
        if ($color === "no other" || empty($list[$color][1])) {
            return 0;
        }

        $count  = 0;
        $size = count($list[$color][2]);
        for ($i = 0; $i < $size; $i++) {
            $h = (1 + $this->holdCount($list, $list[$color][2][$i]));
            $count += (int) $list[$color][1][$i] * $h;
        }
        return $count;
    }
}
