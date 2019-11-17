<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\App\ConfigProvider;

use Psr\Log\{
    LoggerInterface
};

use Nora\Logging\{
    WriterFactory
};

class LoggerModule extends Module
{
    public function configure()
    {
        $this
            ->bind(WriterFactory::class)
            ->to(LoggerWriterFactory::class);
        $this
            ->bind(LoggerFactory::class)
            ->to(LoggerFactory::class);
        $this
            ->bind(LoggerInterface::class)
            ->toProvider(LoggerProvider::class);
    }
}
