<?php


namespace GenAlgo\ComputationData;


use Common\ArrayAble;
use Common\ImmutableDataObjectTrait;

class ComputationEnvironment implements ArrayAble
{
    use ImmutableDataObjectTrait;

    public $computationUuid;
    public $hostname;
    public $gitCommitHash;

    /**
     * ComputationEnvironment constructor.
     * @param string $computationUuid
     * @param string $hostname
     * @param string $gitCommitHash
     */
    public function __construct($computationUuid, $hostname, $gitCommitHash)
    {
        $this->computationUuid = $computationUuid;
        $this->hostname = $hostname;
        $this->gitCommitHash = $gitCommitHash;
        $this->freeze();
    }


}
