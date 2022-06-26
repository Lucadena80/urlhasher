<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\FileDownloader;
use App\Entity\FileStorage;

class HashCommand extends SymfonyCommand
{
    private $fileDownloader;

    public function __construct(FileDownloader $fileDownloader)
    {
        parent::__construct();
        $this->fileDownloader = $fileDownloader;
    }

    protected function configure(): void
    {
        $this->setName("app:hash")
            ->setDescription("Downloads a number of file from url passed by parameters, hashes them in md5 and outputs the result")
            ->setHelp('Retrieve content of the file and prints the hash')
            ->addArgument('url', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'remote url of the file');
    }

    /**
    * Calls the downloader service and outputs the result
    *
    * @return int      Returns 0 if the command succedded and 1 if the command failed
    *
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write(sprintf("\033\143"));
        $output->writeln([
            '====**** File hash console App  ****====',
            '========================================',
            '',
        ]);
        $failed = $this->hashFile($input, $output);
        if ($failed) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('<question>At least one file failed. Try Again? (y/n)</question>' . "\n", false);

            if ($helper->ask($input, $output, $question)) {
                $failed = $this->hashFile($input, $output);
            }
        } else {
            $output->write('<info>All files have been processed without errors!</info>' . "\n");
        }
        $output->write('BYE!');
        return $failed;
    }

    /**
     * Calls the downloader service and outputs the result
     *
     * @return int      Passes 0 if the download succedded and 1 if the download failed
     *
     */
    protected function hashFile(InputInterface $input, OutputInterface $output)
    {
        $file = new FileStorage();
        $return = 0;
        foreach ($input->getArgument('url') as $url) {
            $this->fileDownloader->downloadfile($url, $file);

            if ($file->getHttpCode() == '200') {
                $output->write('Getting Contents of file at path: ' . $url . "\n");
                $output->write('Hashed content: ' . $file->getContents() . "\n");
            } else {
                $output->write('<error>There was an error obtaining one file at path: ' . $url . "</error>\n");
                $output->write('Error Description: ' . $file->getErrorDescription() . "\n");
                $return = 1;
            }
        }

        return $return;
    }
}
