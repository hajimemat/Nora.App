<?php
declare(strict_types=1);

namespace Nora\App\Provide\Routing;

use Nora\DI\Module;
use Nora\DI\Scope;

use Nora\Routing;
use Nora\Http;
use Nora\App;

class Router extends Routing\Standard\Router implements Routing\RouterInterface
{
    private $requestFactory;
    public $spec;

    public function __construct(
        Routing\RouteCollectorInterface $collector,
        Routing\DispatcherFactoryInterface $dispatcherFactory,
        Http\Provide\ServerRequestFactory $requestFactory,
        App\Provide\Configure\ConfigInterface $config,
        App\AppMeta $meta
    ) {
        parent::__construct($collector, $dispatcherFactory);

        $this->requestFactory = $requestFactory;

        // 設定を読んでルートを追加する
        $target = [];
        $this->convertResourceMap($target, $config['resource']['pages']);
        foreach ($target as [$method, $uri, $meta]) {
            $this->collector->addRoute($method, $uri, $meta);
        }

        // 逆引きを作る
        $this->spec = [];
        foreach ($target as $v) {
            $id = strtoupper($v[0]).$v[3];
            $this->spec[$id] = $v[2];
        }
    }

    /**
     * 設定ファイルからルーティングに変換する
     */
    private function convertResourceMap(array &$target, array $resource, $prefix = "", $option = [])
    {
        foreach ($resource as $key => $value) {
            if ($key{0} === '/') {
                $this->convertResourceMap($target, $value, $prefix . $key, $option);
                continue;
            }
            if ($key{0} === "_") { // アンダーバーから始まるものはコンテクスト
                $option[substr($key, 1)] = $value;
                continue;
            }
            if ($key === "*") {
                $keys = ['get','post'];
            } else {
                $keys = explode("|", $key);
            }

            foreach ($keys as $key) {
                $target[] = [
                    $key,
                    $prefix,
                    array_merge(
                        [
                            "uri" => $prefix
                        ],
                        $option,
                        $value
                    ),
                    "/".trim($this->collector->parser->parse($prefix)[0][0], '/')
                ];
            }
        }
    }

    public function __invoke()
    {
        $dispacher = ($this->dispatcherFactory)($this->collector->getData());
        $request = ($this->requestFactory)($GLOBALS, $_SERVER);
        $result = $dispacher->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($result[0] === $this::FOUND) {
            $path = rtrim($this->collector->parser->parse($result[1]['uri'])[0][0], '/');
            array_push($result, $path);
        }
        return $result;
    }
}
