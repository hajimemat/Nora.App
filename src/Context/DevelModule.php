<?php
declare(strict_types=1);
namespace Nora\App\Context;

use Nora\DI\Module;
use Nora\App\Provide;

class DevelModule extends Module
{
    public function configure()
    {
        $this
            ->bind(\Psr\SimpleCache\CacheInterface::class)
            ->to(\Nora\Cache\Handler\NopCache::class);
    }
}
