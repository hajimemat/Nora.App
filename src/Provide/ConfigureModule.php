<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\App\Configuration\ConfigInterface;


class ConfigureModule extends Module
{
    public function configure()
    {
        $this
            ->bind(ConfigInterface::class)
            ->toProvider(ConfigProvider::class);
    }
}
