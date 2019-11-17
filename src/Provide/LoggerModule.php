<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\App\ConfigProvider;

use Psr\Log\{
    LoggerInterface
};


class LoggerModule extends Module
{
    public function configure()
    {
        // $this
        //     ->bind(LoggerInterface::class)
        //     ->toProvider(
    }
}
