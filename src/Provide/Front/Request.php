<?php
declare(strict_types=1);

namespace Nora\App\Provide\Front;

use Psr\Http\Message\ServerRequestInterface;
use Nora\System\EnvFactory;

use Ramsey\Uuid\Uuid;

class Request
{
    /**
     * @var string リクエストID
     */
    public $id;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->time = time();
        $this->id = Uuid::uuid1();
        $this->env = (new EnvFactory)($request->getServerParams()); 
    }

    public function ip()
    {
        return $this->env['REMOTE_ADDR'];
    }

    public function __call($name, $params)
    {
        if (is_callable([$this->request, $name])) {
            return call_user_func_array([
                $this->request,
                $name
            ], $params);
        }
        throw new \Exception("{$name} not defined");
    }
}
