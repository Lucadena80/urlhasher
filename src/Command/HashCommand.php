<?php declare(strict_types=1);

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
    private $fileDownloader;

    public function __construct(FileDownloader $fileDownloader)
    {
        parent::__construct();
        $this->fileDownloader = $fileDownloader;
    }

    protected function configure(): void
    {
        $this->setName("app:hash")
            ->setHelp('Retrieve content of the file and prints the hash')
            ->addArgument('url', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'remote url of the file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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
            $question = new ConfirmationQuestion('At least one file failed. Try Again? (y/n)' . "\n", false);

            if ($helper->ask($input, $output, $question)) {
                $failed = $this->hashFile($input, $output);
            }
        }
        return $failed;
    }

    protected function hashFile(InputInterface $input, OutputInterface $output)
    {

        $file = new FileClass();
        $return = 0;
        foreach ($input->getArgument('url') as $url) {
            $this->fileDownloader->downloadfile($url, $file);

            if ($file->httpCode == '200') {
                $output->write('Getting Contents of file at path: ' . $url . "\n");
                $output->write('Hashed content: ' . $file->contents . "\n");
            } else {
                $output->write('There was an error obtaining one file at path: ' . $url . "\n");
                $output->write('Error Description: ' . $file->errorDescription . "\n");
                $return = 1;
            }
        }

        return $return;
    }
}
