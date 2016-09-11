<?php


namespace GenAlgo\Console;


use GenAlgo\AlgorithmTestRunner;
use GenAlgo\ComputationData\ComputationRequest;
use GenAlgo\Environment;
use GenAlgo\Event\NewOutcomeCreated;
use GenAlgo\Event\PairSelected;
use GenAlgo\Event\PopulationCreated;
use GenAlgo\Event\PopulationFitnessCalculated;
use GenAlgo\Event\RunFinishedEvent;
use GenAlgo\Event\RunStartedEvent;
use GenAlgo\Event\SingleTestFinished;
use GenAlgo\Event\SingleTestStarted;
use GenAlgo\Event\SpezSelected;
use Psr\Log\LoggerInterface;
use GenAlgo\SimpleAlgorithm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TutorialCommand extends Command implements AlgorithmTestRunner\EventListenerInterface
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
     * $run = ComputationRun($computationEnvironment)
     * $request = $run->createRequest($searched, $currentTestCount, $maxTestCount)
     * run($request) [ calls $request->createResult an keeps reference to result ]
     * echo implode (' ', $run->toArray());
     *
     * toArray Results in:
     * ComputationRun:
     *   - details of ComputationEnvironment
     *   - details of ComputationRequest
     *   - details of ComputationResult
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
        $runner = new AlgorithmTestRunner(
            new SimpleAlgorithm(),
            Environment::getComputationEnvironment(),
            Environment::getEvolutionParameters()
        );

        $runner->addEventListener($this);
        $runner->run(Environment::getTargetNumber(), Environment::getTestCount());
    }

    /**
     * @param RunStartedEvent $e
     */
    public function handleRunStarted(RunStartedEvent $e)
    {
        $this->logger->info('RunStartedEvent');
    }

    /**
     * @param SingleTestStarted $e
     */
    public function handleSingleTestStarted(SingleTestStarted $e)
    {
        $this->logger->info('SingleTestStarted');
    }

    /**
     * @param SingleTestFinished $e
     */
    public function handleSingleTestFinished(SingleTestFinished $e)
    {
        $this->logger->info('SingleTestFinished', [
            'result' => $e->getResult()->toArray(),
            'env' => $e->getEnvironment()->toArray()
        ]);
    }

    /**
     * @param RunFinishedEvent $e
     */
    public function handleRunFinished(RunFinishedEvent $e)
    {
        $this->logger->info('RunFinishedEvent');
    }

    public function handleSpezSelected(SpezSelected $e)
    {
        $this->logger->debug('SpezSelected');
    }

    public function handleNewOutcomeCreated(NewOutcomeCreated $e)
    {
        $this->logger->debug('NewOutcomeCreated');
    }

    public function handlePairSelected(PairSelected $e)
    {
        $this->logger->debug('PairSelected');
    }

    public function handlePopulationFitnessCalculated(PopulationFitnessCalculated $e)
    {
        $this->logger->debug('PopulationFitnessCalculated');
    }

    public function handlePopulationCreated(PopulationCreated $e)
    {
        $this->logger->debug('PopulationCreated');
    }
}
