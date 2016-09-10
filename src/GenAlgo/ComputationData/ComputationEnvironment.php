<?php


namespace GenAlgo\ComputationData;


use Common\AbstractDataObject;

class ComputationEnvironment extends AbstractDataObject
{
    protected $computationUuid;
    protected $hostname;
    protected $gitCommitHash;

    protected function __construct() { }
}
