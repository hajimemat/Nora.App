<?php
declare(strict_types=1);

namespace Nora\App\Provide\Routing;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\Routing;
use Nora\Http;

class RoutingModule extends Module
{
    public function configure()
    {
        $this->install(new Routing\Provide\RouterModule());
        $this->install(new Http\Provide\ServerRequestModule());

        $this->bind(Routing\RouterInterface::class)->to(Router::class);
    }
}
