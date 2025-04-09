<?php

namespace App\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerFactory
{
    public static function createLogger(): Logger
    {
        $config = require __DIR__ . '/../../config/logger.php';

        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler($config['log_path'], Logger::DEBUG));

        return $logger;
    }
}
