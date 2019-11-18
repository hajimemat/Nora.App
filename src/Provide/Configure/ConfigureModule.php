<?php
declare(strict_types=1);

namespace Nora\App\Provide\Configure;

use Nora\DI\Module;

/**
 * 設定モジュール
 */
class ConfigureModule extends Module
{
    public function configure()
    {
        $this
            ->bind(ConfigInterface::class)
            ->toProvider(ConfigProvider::class);
    }
}
