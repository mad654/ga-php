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
}
