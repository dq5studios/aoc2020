<?php

declare(strict_types=1);

namespace AOC;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day01 extends Command
{
    /** @var string Command name */
    protected static $defaultName = "day01";

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
        $ff = file_get_contents(__DIR__ . "/day1a.txt");
        $input = explode("\n", $ff);
        sort($input, SORT_NUMERIC);

        foreach ($input as $value) {
            $pair = 2020 - (int) $value;
            if (array_search($pair, $input) !== false) {
                $io->info((string) ((int) $value * $pair));
                return;
            }
        }
    }

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    public function secondHalf(SymfonyStyle $io): void
    {
        $ff = file_get_contents(__DIR__ . "/day1a.txt");
        $input = explode("\n", $ff);
        sort($input, SORT_NUMERIC);

        foreach ($input as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $pair = 2020 - (int) $value;
            $middle = $this->findPair($input, $pair);
            if (!is_null($middle)) {
                $third = 2020 - (int) $value - $middle;
                $io->info((string) ((int) $value * $middle * $third));
                return;
            }
        }
    }

    /**
     * @param string[] $input
     * @param int      $sum
     *
     * @return int|null
     */
    public function findPair(array $input, int $sum): ?int
    {
        foreach ($input as $value) {
            $pair = $sum - (int) $value;
            if (array_search($pair, $input) !== false) {
                return (int) $value;
            }
        }
        return null;
    }
}
