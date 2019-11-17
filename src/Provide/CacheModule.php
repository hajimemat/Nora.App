<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Nora\DI\Module;

use Psr\{
    Log\LoggerInterface,
    SimpleCache\CacheInterface
};


class CacheModule extends Module
{
    public function configure()
    {
        $this
            ->bind(CacheInterface::class)
            ->toProvider(CacheProvider::class);
    }
}
