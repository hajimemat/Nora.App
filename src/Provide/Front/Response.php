<?php
declare(strict_types=1);

namespace Nora\App\Provide\Front;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use Nora\System\EnvFactory;
use Nora\Http\Message\Stream;

class Response
{
    private $response;

    private $bodyFilePoint;

    public function __construct(ResponseInterface $response)
    {
        $this->bodyFilePoint = new Stream(fopen('php://memory', 'r+'));
        $this->response = $response->withBody(
            $this->bodyFilePoint
        );
    }

    public function write($body)
    {
        $this->bodyFilePoint->write($body);
    }

    public function __call($name, $params)
    {
        if (is_callable([$this->response, $name])) {
            return call_user_func_array([
                $this->response,
                $name
            ], $params);
        }
        throw new \Exception("{$name} not defined");
    }

    public function __toString()
    {
        $this->bodyFilePoint->rewind();
        return $this->response->getBody()->getContents();
    }
}
