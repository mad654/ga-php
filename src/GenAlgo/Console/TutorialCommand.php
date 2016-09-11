<?php


namespace GenAlgo\Console;


use GenAlgo\AlgorithmTestRunner;
use GenAlgo\ComputationData\ComputationRequest;
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

        $runner->run(Environment::getTargetNumber(), Environment::getTestCount());
    }
}
