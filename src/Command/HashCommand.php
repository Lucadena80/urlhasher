<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Command;


class HashCommand extends Command
{
    protected static $defaultName = 'app:hash-remote';
    protected static $defaultDescription = 'Hash file from remote server.';

    public function configure(): void
    {
        $this
            ->setHelp('Retrieve content of the file and prints the hash')
            ->addArgument('url', InputArgument::REQUIRED, 'remote url of the file');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->hashFile($input, $output);
        return 0;
    }
}
