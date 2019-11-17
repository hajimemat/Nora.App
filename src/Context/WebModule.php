<?php
declare(strict_types=1);
namespace Nora\App\Context;

use Nora\DI\Module;

use Nora\App\Routing\{
    RouterInterface,
    RouterProvider
};

use Nora\App\Routing\RoutingModule;

class WebModule extends Module
{
    public function configure()
    {
        $this->install(new RoutingModule());
    }
}
