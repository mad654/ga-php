<?php


namespace Example\Console;


use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HelloWorldCommand extends Command
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * HelloWorldCommand constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('example:hello-world');
        $this->setDescription('Guess what it is! Additionally it logs an error - sometimes');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $style->writeln("Hello world!");
        $name = $style->ask("Whats your name?", 'Hugu');
        $this->logger->info("User gave his name: {n}", [ 'n' => $name ]);
        $style->success("Hello $name!");

        $shouldLogError = rand(0,1);
        if ($shouldLogError > 0) {
            $this->logger->error("A DEMO ERROR");
        }
    }
}
