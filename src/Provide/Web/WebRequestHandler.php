<?php
declare(strict_types=1);

namespace Nora\App\Provide\Web;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\Routing;
use Nora\Http;
use Nora\App\AppMeta;

class WebRequestHandler
{
    private $meta;
    private $spec;

    public function __construct(AppMeta $meta, Routing\RouterInterface $router)
    {
        $this->meta = $meta;
        $this->spec = $router->spec;
    }

    /**
     * Getリクエスト
     */
    public function get($uri, $params)
    {
        $this->handle('GET', $uri, $params);
    }

    protected function handle($method, $uri, $params)
    {
        $spec = $this->spec[$method.$uri];

        $vars = array_map(function($v) {
            $ret = "";
            foreach (explode("-", strtolower($v)) as $vv) {
                $ret .= ucfirst($vv);
            }
            return $ret;
        }, array_filter(explode("/", $uri), function($v) {
            return !empty($v);
        }));


        // リクエストをクラスに変換
        $class = $this->meta->name . "\\Page\\" . implode("\\", $vars);

        (new $class($this->meta, $spec))->{"on".ucfirst(strtolower($method))}( );
    }
}
