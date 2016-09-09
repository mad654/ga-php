<?php


namespace GenAlgo\ComputationData;


use Common\ArrayAble;
use DateTime;

class ComputationResult implements ArrayAble
{
    const RESULT_TYPE_OK = 'OK';
    const RESULT_TYPE_SELECTION_TIMEOUT = 'SELECTION_TIMEOUT';
    const RESULT_TYPE_POPULATION_TIMEOUT = 'POPULATION_TIMEOUT';

    /**
     * @var ComputationRequest
     */
    private $request;

    /**
     * @var float microseconds
     */
    private $start;

    /**
     * @var float microseconds
     */
    private $stop;

    /**
     * @var float microseconds
     */
    private $diff;

    /**
     * can be one of this:
     * [
     *      self::RESULT_TYPE_OK
     *      self::RESULT_TYPE_SELECTION_TIMEOUT
     *      self::RESULT_TYPE_POPULATION_TIMEOUT
     * ]
     *
     * @var string|enum|null
     */
    private $resultType;

    /**
     * @var misc
     */
    private $result;

    /**
     * @var array
     */
    private $resultData;

    /**
     * @var int
     */
    private $lastPopulationNumber;

    /**
     * ComputationResult constructor.
     * @param ComputationRequest $request
     */
    public function __construct(ComputationRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return ComputationResult
     */
    public function start() {
        $this->validateNotYetStarted();
        $this->validateNotYetStopped();

        $this->start = $this->getNow();

        return $this;
    }

    /**
     * @param $result
     * @param array $data
     * @param int $populationNumber
     * @return ComputationResult
     */
    public function foundResult($result, $data, $populationNumber) {
        $this->validateStarted();
        $this->validateNotYetStopped();

        $this->stop();
        $this->resultType = self::RESULT_TYPE_OK;
        $this->result = $result;
        $this->resultData = $data;
        $this->lastPopulationNumber = $populationNumber;

        return $this;
    }

    /**
     * @param array $lastPopulation
     * @param int $populationNumber
     * @return ComputationResult
     */
    public function populationTimedOut(array $lastPopulation, $populationNumber) {
        $this->setTimedOut(
            $lastPopulation,
            $populationNumber,
            self::RESULT_TYPE_POPULATION_TIMEOUT
        );

        return $this;
    }

    /**
     * @param array $currentPopulation
     * @param $populationNumber
     * @return ComputationResult
     */
    public function selectionTimedOut(array $currentPopulation, $populationNumber) {
        $this->setTimedOut(
            $currentPopulation,
            $populationNumber,
            self::RESULT_TYPE_SELECTION_TIMEOUT
        );

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'started'       => $this->microtimeToDate($this->start)->format(DATE_ATOM),
            'stopped'       => $this->microtimeToDate($this->stop)->format(DATE_ATOM),
            'resultType'   => $this->resultType,
            'result'        => $this->result,
            'resultData'   => json_encode($this->resultData),
            'runtime'       => $this->microtimeToDate($this->diff)->format('U.u'),
            'lastPopulationNumber' => $this->lastPopulationNumber,
        ];

        return array_merge($result, $this->request->toArray());
    }

    /**
     * @param array $lastPopulation
     * @param $populationNumber
     * @param $resultType
     */
    private function setTimedOut(array $lastPopulation, $populationNumber, $resultType)
    {
        $this->validateStarted();
        $this->validateNotYetStopped();

        $this->stop();
        $this->resultType = $resultType;
        $this->resultData = $lastPopulation;
        $this->lastPopulationNumber = $populationNumber;
    }

    private function validateStarted()
    {
        if (is_null($this->start)) {
            throw new \DomainException("Call start first");
        }
    }

    private function validateNotYetStarted() {
        if (!is_null($this->start)) {
            throw new \DomainException("Already started, update results or create new instance");
        }
    }

    private function validateNotYetStopped()
    {
        if (!is_null($this->stop)) {
            throw new \DomainException("Already stopped, create new instance");
        }
    }

    private function stop()
    {
        $this->stop = $this->getNow();
        $this->diff = $this->stop - $this->start;
    }

    private function getNow()
    {
        return microtime(true);
    }

    private function microtimeToDate($microtime) {
        $micro = sprintf("%06d",($microtime - floor($microtime)) * 1000000);
        return new DateTime( date('Y-m-d H:i:s.'.$micro, $microtime) );
    }

}
