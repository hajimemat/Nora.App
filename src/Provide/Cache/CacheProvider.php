<?php
declare(strict_types=1);

namespace Nora\App\Provide\Cache;


use Nora\DI\ProviderInterface;

use Nora\App\AppMeta;
use Nora\Cache\CacheFactory;

class CacheProvider implements ProviderInterface
{
    private $meta;

    public function __construct(AppMeta $meta)
    {
        $this->meta = $meta;
    }

    public function get( )
    {
        $cacheDir = $this->meta->tmpDir . "/cache";
        return (new CacheFactory)("file", $cacheDir, 3600);
    }
}
