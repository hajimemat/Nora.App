<?php
declare(strict_types=1);

namespace Nora\App\Provide\Front;

use Nora\DI\{
    Module,
    Scope
};

use Nora\Http\Provide\{
    ServerRequestFactory
};

class FrontModule extends Module
{
    public function configure()
    {
        $this
            ->bind(ServerRequestFactory::class)
            ->to(ServerRequestFactory::class);
        $this
            ->bind(FrontInterface::class)
            ->to(Front::class);
    }
}
