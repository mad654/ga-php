<?php


namespace GenAlgo\Console;


use GenAlgo\ConfigurationValues;
use GenAlgo\Environment;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TutorialCommand extends Command
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * TutorialCommand constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('gen-algo:tutorial');
        $this->setDescription('Find simple function based on given number');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $sourceRootPath = Environment::getSourceRootPath();
        require_once "$sourceRootPath/SimpleDemo.php";
        runSimpleDemo(42, 10, ConfigurationValues::fromArray([]));

        // @todo: mad654: fetch all from from .env (require searched and testcount)
        // @todo: mad654: document configuration options in readme
    }
}
