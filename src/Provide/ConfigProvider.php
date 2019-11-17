<?php
declare(strict_types=1);

namespace Nora\App\Provide;


use Nora\DI\ProviderInterface;

use Nora\App\Extension;
use Nora\App\Meta;
use Nora\App\Configuration\{
    ConfigureFactory,
    DefineConstants
};

use Psr\SimpleCache\CacheInterface;


class ConfigProvider implements ProviderInterface
{
    private $meta;

    public function __construct(Meta $meta, CacheInterface $cache)
    {
        $this->meta = $meta;
        $this->cache = $cache;
    }

    public function get( )
    {
        // キャッシュがあればキャッシュを返す
        if ($this->cache->has('config')) {
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
