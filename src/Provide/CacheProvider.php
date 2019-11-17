<?php
declare(strict_types=1);

namespace Nora\App\Provide;


use Nora\DI\ProviderInterface;

use Nora\App;
use Nora\Cache\CacheFactory;

class CacheProvider implements ProviderInterface
{
    private $meta;

    public function __construct(App\Meta $meta)
    {
        $this->meta = $meta;
    }

    public function get( )
    {
        $cacheDir = $this->meta->tmpDir . "/cache";
        return (new CacheFactory)("file", $cacheDir, 3600);
    }
}
