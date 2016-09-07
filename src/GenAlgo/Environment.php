<?php


namespace GenAlgo;


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
     * @return string
     */
    public static function getSourceRootPath()
    {
        return self::get('APP_SRC_DIR');
    }

    /**
     * @return ConfigurationValues
     */
    public static function getEvolutionParameters()
    {
        $keys = [
            'MAX_POPULATIONS'        => 'maxPopulations',
            'POPULATION_SIZE'        => 'populationSize',
            'CROSSOVER_RATE'         => 'crossoverRate',
            'MUTATION_RATE'          => 'mutationRate',
            'MAX_SELECTION_ATTEMPTS' => 'maxSelectionAttempts',
        ];

        $result = [];

        foreach ($keys as $envKey => $configKey) {
            if (!is_null(self::get($envKey))) {
                $result[$configKey] = self::get($envKey);
            }
        }

        return ConfigurationValues::fromArray($result);
    }

    public static function getTargetNumber()
    {
        return self::get('TARGET_NUMBER');
    }

    public static function getTestCount()
    {
        return self::get('TEST_COUNT');
    }
}
