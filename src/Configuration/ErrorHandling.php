<?php
declare(strict_types=1);
namespace Nora\App\Configuration;

use Nora\App\Meta;

class ErrorHandling
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * エラーログを管理する
     *
     * @param Config
     */
    public function __invoke(Config $config)
    {
    }

}
