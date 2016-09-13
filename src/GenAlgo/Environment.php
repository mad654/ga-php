<?php


namespace GenAlgo;


use GenAlgo\ComputationData\ComputationEnvironment;

class Environment
{
    public static function getAppName() {
        return self::get('EXAMPLE_APP_NAME', 'DEFAULT-APP-NAME');
    }

    private static function get($key, $default = null) {
        $result = getenv($key);

        if ($result === false || is_null($result)) {
            return $default;
        }

        return $result;
    }

    /**
     * @return ConfigurationValues
     */
    public static function getEvolutionParameters()
    {
        return new ConfigurationValues(
            self::get('MAX_POPULATIONS', 100),
            self::get('POPULATION_SIZE', 100),
            self::get('CROSSOVER_RATE', 0.7),
            self::get('MUTATION_RATE', 0.001),
            self::get('MAX_SELECTION_ATTEMPTS', 10000)
        );
    }

    public static function getTargetNumber()
    {
        return self::get('TARGET_NUMBER');
    }

    public static function getTestCount()
    {
        return self::get('TEST_COUNT');
    }

    /**
     * @return string
     */
    public static function getCurrentCommitHash()
    {
        exec('git rev-list HEAD -n1', $output);
        return (string) $output[0];
    }

    /**
     * @return string
     */
    public static function getHostname()
    {
        exec('hostname', $output);
        return (string) $output[0];
    }

    /**
     * @return string
     */
    public static function getNewUuid() {
        return uniqid('', true);
    }

    /**
     * @return ComputationEnvironment
     */
    public static function getComputationEnvironment() {
        return new ComputationEnvironment(
            self::getNewUuid(),
            self::getHostname(),
            self::getCurrentCommitHash()
        );
    }

    /**
     * @return string
     */
    public static function getAppMemoryLimit()
    {
        return self::get('APP_MEMORY_LIMIT', '512M');
    }
}
