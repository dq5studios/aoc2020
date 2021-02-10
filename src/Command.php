<?php

declare(strict_types=1);

namespace AOC;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class Command extends SymfonyCommand
{
    /**
     * Define options
     *
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {
        $this->setName(static::class)->setDescription("Puzzle for the day");
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
    abstract public function firstHalf(SymfonyStyle $io): void;

    /**
     * Second half of the day
     *
     * @param SymfonyStyle $io
     */
    abstract public function secondHalf(SymfonyStyle $io): void;
}
