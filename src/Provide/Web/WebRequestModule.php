<?php
declare(strict_types=1);

namespace Nora\App\Provide\Web;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\Routing;
use Nora\Http;

class WebRequestModule extends Module
{
    public function configure()
    {
        $this->bind(WebRequestHandler::class)
            ->to(WebRequestHandler::class);
    }
}
