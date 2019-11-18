<?php
declare(strict_types=1);

namespace Nora\App\Provide\Cache;

use Nora\DI\Module;

use Psr\{
    Log\LoggerInterface,
    SimpleCache\CacheInterface
};
/**
 * キャッシュモジュール
 */
class SimpleCacheModule extends Module
{
    public function configure()
    {
        $this
            ->bind(CacheInterface::class)
            ->toProvider(CacheProvider::class);
    }
}
