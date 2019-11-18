<?php
declare(strict_types=1);

namespace Nora\App\Provide\Front;

use Psr\Http\Message\ResponseInterface;

class ResponseFactory
{
    public function __invoke(ResponseInterface $response)
    {
        return new Response($response);
    }
}
