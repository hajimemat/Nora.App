<?php
declare(strict_types=1);
namespace Nora\App\Configuration;

use Nora\App\Meta;

class DefineConstants
{
    /**
     * @param Config
     */
    public function __invoke(Config $config)
    {
        $env = $config['env'];
        $constants = [];
        foreach (["constants", "constants-{$env}"] as $key) {
            $constants = array_merge($constants, $config[$key] ?? []);
        }

        foreach ($constants as $k => $v) {
            if (!defined($k)) {
                define($k, $v);
            }
        }
    }

}
