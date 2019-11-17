<?php
declare(strict_types=1);
namespace Nora\App\Configuration;

use Nora\App\Meta;

/**
 * PHPの実行時設定を行う
 */
class SettingRuntime
{
    /**
     * @param Config
     */
    public function __invoke(Config $config)
    {
        if ($config['lang']) {
            mb_language($config['lang']);
        }
        if ($config['timezone']) {
            date_default_timezone_set($config['timezone']);
        }
    }

}
