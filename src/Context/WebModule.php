<?php
declare(strict_types=1);
namespace Nora\App\Context;

use Nora\DI\Module;

use Nora\App;
use Nora\Http;
use Nora\Routing;

use Psr\Http\Message\ResponseInterface;
use Nora\Http\Message\Response;


class WebModule extends Module
{
    public function configure()
    {
        $this->install(new Http\Provide\ServerRequestModule());
        $this->Install(new Routing\Provide\RouterModule());
        $this->install(new App\Provide\Front\FrontModule());

        $this->bind(ResponseInterface::class)
            ->to(Response::class);
    }
}
