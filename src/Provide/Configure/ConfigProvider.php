<?php
declare(strict_types=1);

namespace Nora\App\Provide\Configure;

use Nora\DI\ProviderInterface;
use Nora\App\AppMeta;
use Psr\SimpleCache\CacheInterface;


class ConfigProvider implements ProviderInterface
{
    private $meta;

    public function __construct(AppMeta $meta, CacheInterface $cache)
    {
        $this->meta = $meta;
        $this->cache = $cache;
    }

    public function get( )
    {
        // キャッシュがあればキャッシュを返す
        if ($this->cache->has('config') && !preg_match('/devel/', $this->meta->context)) {
            return $this->cache->get('config');
        }

        $configure = (new ConfigureFactory)(
            $this->meta,
            $this->meta->context
        );

        $config = $configure->configure();

        // キャッシュを保存
        $this->cache->set('config', $config);

        return $config;
    }
}
