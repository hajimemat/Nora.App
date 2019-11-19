<?php
declare(strict_types=1);

namespace Nora\App\Provide\Resource;

use Nora\DI\Module;
use Nora\DI\Scope;

use Psr\SimpleCache;
use Nora\App;
/**
 * リソースモジュール
 */
class ResourceRepository implements ResourceRepositoryInterface
{
    public function __construct(
        App\Provide\Configure\ConfigInterface $config,
        SimpleCache\CacheInterface $cache
    ) {

        // リソースをビルドする
        $resource = $config['resource'];

        // ページ用リポジトリ
        // 設定を読んでルートを追加する
        foreach (['page'] as $type) {
            if (!isset($config['resource'][$type])) {
                continue;
            }
            $target = [];
            $this->convertResourceMap($target, $config['resource'][$type] ?? []);
            foreach ($target as [$method, $uri, $meta]) {
                $this->addResource(
                    $method, 
                    $type.'://'.trim($uri,'/'),
                    $meta
                );
            }
        }

        echo '<pre>';
        var_dump($this->data);
        //
        // // 逆引きを作る
        // $this->spec = [];
        // foreach ($target as $v) {
        //     $id = strtoupper($v[0]).$v[3];
        //     $this->spec[$id] = $v[2];
        // }
    }

    public function addResource($method, $uri, $meta)
    {
        $this->data[$uri][$method] = $meta;
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
                    )
                ];
            }
        }
    }
}
