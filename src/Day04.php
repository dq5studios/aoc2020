<?php

declare(strict_types=1);

namespace AOC;

use AOC\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day04 extends Command
{
    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $valid = [
            "byr" => "byr",
            "iyr" => "iyr",
            "eyr" => "eyr",
            "hgt" => "hgt",
            "hcl" => "hcl",
            "ecl" => "ecl",
            "pid" => "pid",
        ];
        $input = explode("\n\n", $this->input);
        $count = 0;
        foreach ($input as $passport) {
            $passport = str_replace("\n", " ", $passport);
            preg_match_all('/([^:]*):([^ ]*)( |$)/', $passport, $tags);
            $passport = array_combine($tags[1], $tags[2]);
            $missing = array_diff_key($valid, $passport);
            if (empty($missing)) {
                $count++;
            }
        }
        $io->success((string) $count);
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $valid = [
            "byr" => fn(string $x): bool => (1920 <= (int) $x && (int) $x <= 2002),
            "iyr" => fn(string $x): bool => (2010 <= (int) $x && (int) $x <= 2020),
            "eyr" => fn(string $x): bool => (2020 <= (int) $x && (int) $x <= 2030),
            "hgt" => fn(string $x): bool => $this->heightValidator($x),
            "hcl" => fn(string $x): bool => (bool) (preg_match("/^#[a-f0-9]{6}$/", $x)),
            "ecl" => fn(string $x): bool => (bool) (preg_match("/^(amb|blu|brn|gry|grn|hzl|oth)$/", $x)),
            "pid" => fn(string $x): bool => (bool) (preg_match("/^[0-9]{9}$/", $x)),
        ];
        $input = explode("\n\n", $this->input);
        $count = 0;
        foreach ($input as $passport) {
            $passport = str_replace("\n", " ", $passport);
            preg_match_all('/([^:]*):([^ ]*)( |$)/', $passport, $tags);
            $passport = array_combine($tags[1], $tags[2]);
            $missing = array_diff_key($valid, $passport);
            if (empty($missing)) {
                foreach ($valid as $tag => $validator) {
                    if (!$validator($passport[$tag])) {
                        continue 2;
                    }
                }
                $count++;
            }
        }
        $io->success((string) $count);
    }

    public function heightValidator(string $x): bool
    {
        $r = preg_match('/^([0-9]+)(cm|in)$/', $x, $h);
        if (empty($r)) {
            return false;
        }
        return match ($h[2]) {
            "in" => (59 <= (int) $h[1] && (int) $h[1] <= 76),
            "cm" => (150 <= (int) $h[1] && (int) $h[1] <= 193),
        };
    }
}
