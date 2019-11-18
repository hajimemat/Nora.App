<?php
declare(strict_types=1);
namespace Nora\App\Provide\Configure;

use Nora\App\AppMeta;

class ConfigureFactory
{
    private $meta;
    private $contexts;

    public function __invoke(AppMeta $meta, $contexts) : Configures
    {
        $contexts = array_reverse(explode('-', $contexts));

        $configures = [];
        foreach ($contexts as $context) {
            $configures[] = new Configure(
                $meta,
                $context
            );
        }

        return new Configures($configures);
    }
}
