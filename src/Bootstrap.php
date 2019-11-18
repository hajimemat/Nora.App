<?php

declare(strict_types=1);

namespace Nora\App;

class Bootstrap
{
    public function getApp(
        string $name, 
        string $contexts,
        string $appDir = '',
        string $cacheNamespace = null
    ) : AppInterface {

        return $this->newApp(
            new AppMeta($name, $contexts, $appDir),
            $contexts,
            null,
            $cacheNamespace
        );
    }

    public function newApp(
        AppMeta $meta,
        string $contexts,
        Cache $cache = null,
        string $cacheNamespace = null
    ) : AppInterface {
        $injector = new AppInjector(
            $meta->name,
            $contexts,
            $meta,
            $cacheNamespace
        );
        // $cache = $cache instanceof Cache ? $cache: $injector->getCachedInstance(Cache::class);
        $appId = $meta->name() . $contexts . $cacheNamespace;

        $app = $injector->getCachedInstance(AppInterface::class);

        return $app;
    }
}
