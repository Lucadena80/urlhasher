<?php

namespace App;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\FileDownloader;
use App\FileClass;

/**
 * Author: Luca De Nardis <lucadena80@gmail.com>
 */
class Command extends SymfonyCommand
{
    
    public function __construct()
    {
        parent::__construct();
    }
    protected function hashFile(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            '====**** File hash console App  ****====',
            '==========================================',
            '',
        ]);
        $fileDownloader = new FileDownloader();
        $file = new FileClass();
        $file_contents = $fileDownloader->downloadFile($input->getArgument('url'),$file);
        

        if ($file_contents) {

            $output->write($this->getGreeting() . ', ' . 'Getting Contents of file at path: ' . $input->getArgument('url') . "\n");
            $output->write($file_contents->contents. "\n");
            $output->write($file_contents->errorCode. "\n");
            $output->write($file_contents->errorDescription. "\n");


        } else {
            $output->write($this->getGreeting() . ', ' . 'The file at path: ' . $input->getArgument('url') . " was not loaded properly\n");
        }
    }






    private function getGreeting()
    {
        /* This sets the $time variable to the current hour in the 24 hour clock format */
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            return "Good morning";
        } else
            /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
            if ($time >= "12" && $time < "17") {
                return "Good afternoon";
            } else
                /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
                if ($time >= "17" && $time < "19") {
                    return "Good evening";
                } else
                    /* Finally, show good night if the time is greater than or equal to 1900 hours */
                    if ($time >= "19") {
                        return "Good night";
                    }
    }
}
