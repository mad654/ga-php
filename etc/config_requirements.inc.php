<?php
# find details for usage on https://github.com/vlucas/phpdotenv#requiring-variables-to-be-set

/* @var \Dotenv\Dotenv $config */

$config->required('APP_SRC_DIR');
$config->required('APP_CACHE_DIR');
$config->required('APP_LOG_DIR');
$config->required('APP_LOG_LEVEL');
