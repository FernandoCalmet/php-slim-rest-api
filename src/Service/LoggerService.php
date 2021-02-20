<?php

declare(strict_types=1);

namespace App\Service;

use Monolog\Logger;

final class LoggerService
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function setDebug(string $msg)
    {
        return $this->logger->debug($msg . ' (LEVEL-100)');
    }

    public function setInfo(string $msg)
    {
        return $this->logger->info($msg . ' (LEVEL-200)');
    }

    public function setWarning(string $msg)
    {
        return $this->logger->warning($msg . ' (LEVEL-300)');
    }

    public function setError(string $msg)
    {
        return $this->logger->error($msg . ' (LEVEL-400)');
    }

    public function setCritical(string $msg)
    {
        return $this->logger->critical($msg . ' (LEVEL-500)');
    }

    public function setAlert(string $msg)
    {
        return $this->logger->alert($msg . ' (LEVEL-550)');
    }

    public function setEmergency(string $msg)
    {
        return $this->logger->emergency($msg . ' (LEVEL-600)');
    }
}
