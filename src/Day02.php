<?php

declare(strict_types=1);

namespace AOC;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day02 extends Command
{
    /** @var string Command name */
    protected static $defaultName = "day02";

    /**
     * Define options
     *
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {
        $this->addArgument("puzzle", InputArgument::OPTIONAL, "A|B", "A");
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $day = $input->getArgument("puzzle");

        switch ($day) {
            case "1":
            case "a":
            case "A":
                $this->firstHalf($io);
                break;
            case "2":
            case "b":
            case "B":
                $this->secondHalf($io);
                break;
        }
        return Command::SUCCESS;
    }

    /**
     * First half of the day
     *
     * @param SymfonyStyle $io
     */
    public function firstHalf(SymfonyStyle $io): void
    {
        $ff = file_get_contents(__DIR__ . "/day2a.txt");

        $valid = 0;
        preg_match_all("/([0-9]+)-([0-9]+) ([a-z]): ([a-z]*)/", $ff, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            [$a, $min, $max, $char, $pass] = $match;
            preg_match_all("/{$char}/", $pass, $count);
            if (((int) $min <= count($count[0])) && ((int) $max >= count($count[0]))) {
                $valid++;
            }
        }

        $io->info((string) $valid);
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
    }
}
