<?php
declare(strict_types=1);

namespace Nora\App\Provide\Front;

use Psr\Http\Message\ServerRequestInterface;

class RequestFactory
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new Request($request);
    }
}
