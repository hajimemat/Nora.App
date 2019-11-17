<?php
declare(strict_types=1);

namespace Nora\App;


use Nora\DI\Module;
use Nora\DI\Scope;
use Nora\DI\ProviderInterface;

use Nora\App\Extension;
use Nora\App\Configuration\{
    ConfigureFactory
};


class ConfigProvider implements ProviderInterface
{
    private $meta;

    public function __construct(Meta $meta)
    {
        $this->meta = $meta;
    }

    public function get( )
    {
        $configure = (new ConfigureFactory)(
            $this->meta,
            $this->meta->context
        );

        $config = $configure->configure();
        return $config;
    }
}
