<?php
declare(strict_types=1);

namespace Fake\App\Module;

use Fake\App\Provide;

use Nora\App\AppInterface;

use Nora\App\Configuration\{
    ConfigInterface,
    DefineConstants,
    SettingRuntime,
    ErrorHandling
};

use Psr\Log\LoggerInterface;

class App implements AppInterface
{
    public $hoge;
    public $config;

    public function __construct(
        Provide\Hoge $hoge,
        ConfigInterface $config,
        LoggerInterface $logger
    ) {
        $this->hoge = $hoge;
        $this->config = $config;

        // 定数定義を行う
        (new DefineConstants)($this->config);

        // PHPの設定を変更する
        (new SettingRuntime)($this->config);

        // エラーハンドリングを行う
        (new ErrorHandling($logger))(true);
    }

    public function configure()
    {
    }
}
