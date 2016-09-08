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
        runSimpleDemo(
            Environment::getTargetNumber(),
            Environment::getTestCount(),
            Environment::getEvolutionParameters()
        );

        /**
         * RESULT LOGGING SPEC
         *
         * - result_type ['OK', 'SELECTION_TIMEOUT', 'POPULATION_TIMEOUT']
         * - result
         * - result_data
         * - runtime
         *
         * - runUuid
         * - hostname
         * - git_commit
         *
         * - population_size
         * - crossover_rate
         * - mutation_rate
         * - max_selection_attempts
         * - max_population_count
         *
         * - searched
         * - test_count
         * - last_population_number
         *
         * - started [\DateTime]
         * - stopped [\DateTime]
         * 
         * CMD IO SPEC
         * - progress test count: x/y done
         *   - selection counter x/MAX
         *   - population counter x/MAX
         *   - result
         *   - runtime in sec
         */
    }
}
