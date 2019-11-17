<?php
declare(strict_types=1);
namespace Nora\App\Configuration;

use Nora\App\Meta;

class ConfigureFactory
{
    private $meta;
    private $contexts;

    public function __invoke(Meta $meta, $contexts) : Configures
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
