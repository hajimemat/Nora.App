<?php
declare(strict_types=1);
namespace Nora\App\Routing;

use Nora\DI\{Module, Scope};

class RoutingModule extends Module
{
    public function configure()
    {
        $this
            ->bind(RouterInterface::class)
            ->toProvider(RouterProvider::class);
    }
}
