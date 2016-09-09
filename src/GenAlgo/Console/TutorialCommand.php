<?php


namespace GenAlgo\Console;


use GenAlgo\ConfigurationValues;
use GenAlgo\Environment;
use Psr\Log\LoggerInterface;
use GenAlgo\SimpleAlgorithm;
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
     * @var SymfonyStyle
     */
    private $io;

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
        $this->io = new SymfonyStyle($input, $output);

        ini_set('memory_limit', Environment::getAppMemoryLimit());
        $this->runSimpleDemo();
    }

    /**
     * @todo SimpleAlgorithm->findSolution should return result like this and should be logged
     *
     * RESULT LOGGING SPEC
     *
     * ComputationData:
         * ComputationRequest
         * - searched
         * - test_count - von/bis
         * - ConfigurationValues
         *   - population_size -> ConfigurationValues
         *   - crossover_rate -> ConfigurationValues
         *   - mutation_rate -> ConfigurationValues
         *   - max_selection_attempts -> ConfigurationValues
         *   - max_population_count -> ConfigurationValues
         *
         * ComputationResult
         * - started [\DateTime]
         * - stopped [\DateTime]
         * - result_type ['OK', 'SELECTION_TIMEOUT', 'POPULATION_TIMEOUT']
         * - result
         * - result_data
         * - runtime
         * - last_population_number
         *
         * ComputationEnvironment
         * - runUuid -> Environment
         * - hostname -> Environment
         * - git_commit -> Environment
         *
     *
     *
     * CMD IO SPEC
     * - progress test count: x/y done
     *   - selection counter x/MAX
     *   - population counter x/MAX
     *   - result
     *   - runtime in sec
     */
    /**
     * Run simple demo for TEST_COUNT times
     */
    private function runSimpleDemo()
    {
        $simpleDemo = new SimpleAlgorithm();

        $commitId       = Environment::getCurrentCommitHash();
        $searchedValue  = Environment::getTargetNumber();
        $testCount      = Environment::getTestCount();
        $c              = Environment::getEvolutionParameters();

        for ($i = 1; $i <= $testCount; $i++) {
            $start = microtime(true);

            echo "$commitId ";
            echo $c->PopulationSize() . ' ';
            echo $c->CrossoverRate() . ' ';
            echo $c->MutationRate() . ' ';
            echo SimpleAlgorithm::CHROMOSOME_LENGTH . ' ';
            echo $searchedValue . ' ';
            echo $c->MaxSelectionAttempts() . ' ';
            echo date(DATE_ATOM) . ' ';
            echo "$i/" . $testCount . " ";
            $result = $simpleDemo->findSolution($searchedValue, $c);
            $stop = microtime(true);
            $diff = $stop - $start;

            echo array_shift($result) . ' ';
            echo implode(';', $result) . ' ';

            echo date(DATE_ATOM) . ' ';
            echo "$start $stop $diff";
            echo PHP_EOL;
        }
    }
}
