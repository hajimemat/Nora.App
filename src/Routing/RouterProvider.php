<?php
declare(strict_types=1);

namespace Nora\App\Routing;


use Nora\DI\ProviderInterface;

use Nora\App\Extension;
use Nora\App\Meta;
use Nora\App\Configuration\{
    ConfigureFactory,
    DefineConstants
};

use Psr\SimpleCache\CacheInterface;


class RouterProvider implements ProviderInterface
{
    private $meta;

    public function __construct(Meta $meta, CacheInterface $cache)
    {
        $this->meta = $meta;
        $this->cache = $cache;
    }

    public function get( ) : Router
    {
        $router = new Router();

        return $router;
    }
}
