<?php

namespace App\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\FileDownloader;
use App\FileClass;

class HashCommand extends SymfonyCommand
{
    public function __construct(FileDownloader $fileDownloader)
    {
        parent::__construct();
        $this->fileDownloader = $fileDownloader;
    }

    public function configure(): void
    {
        $this->setName("app:hash")
            ->setHelp('Retrieve content of the file and prints the hash')
            ->addArgument('url', InputArgument::REQUIRED, 'remote url of the file');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            '====**** File hash console App  ****====',
            '==========================================',
            '',
        ]);
        $failed = $this->hashFile($input, $output);
        if ($failed) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Try Again? (y/n)' . "\n", false);
    
            if ($helper->ask($input, $output, $question)) {
                 $failed = $this->hashFile($input, $output);
                
            }
        }
        return $failed;
    }
    
    protected function hashFile(InputInterface $input, OutputInterface $output)
    {
        
        $file = new FileClass();
        $this->fileDownloader->downloadfile($input->getArgument('url'),$file);
        

        
            if($file->errorCode == '200') {
                $output->write('Getting Contents of file at path: ' . $input->getArgument('url') . "\n");
                $output->write($file->contents. "\n");
                $output->write($file->errorCode. "\n");
                $output->write($file->errorDescription. "\n");
                $return = 0; 
            } else {
                $output->write('There was an error obtaining the file at path: ' . $input->getArgument('url') . "\n");
                $output->write($file->errorCode. "\n");
                $output->write($file->errorDescription. "\n");
                $return = 1; 
            }
            
        
            return $return;
       
    }
}
