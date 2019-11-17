<?php
declare(strict_types=1);

namespace Fake\App\Module;

use Nora\App\AppInterface;
use Nora\App\Extension;
use Nora\DI\Module;
use Fake\App\Provide;

use Nora\App\Configuration\{
    ConfigInterface,
    DefineConstants,
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

        // エラーハンドリングを行う
        (new ErrorHandling($logger))(true);
    }

    public function configure()
    {
    }
}
