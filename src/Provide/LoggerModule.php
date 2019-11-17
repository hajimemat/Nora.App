<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\App\ConfigProvider;


class LoggerModule extends Module
{
    public function configure()
    {
        $this
            ->bind(LoggerInterface::class)
            ->toProvider(LoggerProvider::class);
    }
}
