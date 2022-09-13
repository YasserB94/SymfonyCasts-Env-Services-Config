<?php

namespace App\Command;

use App\Services\MixRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:talk-to-me',
    description: 'I will great you depending on my parameters!',
)]
class TalkToMeCommand extends Command
{
    public function __construct(private MixRepository $mixRepository)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Provide your name')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'Will make me yell');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('arg1') ?: 'Command line user';
        $yell = $input->getOption('yell');
        $msg = sprintf('Hello there %s!', $name);
        if ($yell) {
            $msg = strtoupper($msg);
        }
        $io->success($msg);

        if ($io->confirm('Would you like a mix recommendation?')) {
            $mixes = $this->mixRepository->findAll();
            $mix = $mixes[array_rand($mixes)];
            $io->note('Here is your reccomendation: ' . $mix['title']);
        }

        return Command::SUCCESS;
    }
}
