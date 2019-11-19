<?php
declare(strict_types=1);

namespace Nora\App\Routing;

use Nora\DI\Module;

class Router implements RouterInterface
{
    public function route($request)
    {
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();
    }
}
