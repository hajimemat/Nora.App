<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Psr\Log\LoggerInterface;

use Nora\DI\Module;
use Nora\DI\Scope;
use Nora\DI\ProviderInterface;

use Nora\App\Meta;
use Nora\App\Extension;
use Nora\App\Configuration\{
    ConfigureFactory
};

use Nora\App\Configuration\ConfigInterface;
use Nora\Logging\{
    WriterFactory
};

class LoggerProvider implements ProviderInterface
{
    private $meta;

    public function __construct(
        Meta $meta,
        ConfigInterface $config,
        LoggerFactory $factory)
    {
        $this->meta = $meta;
        $this->config = $config;
        $this->factory = $factory;
    }

    public function get()
    {
        // ロガーを作成する
        $logger = ($this->factory)($this->config['logging']);

        // ロガーをスタートしてみる
        $logger->info('ロガー起動', [
            'file' => __FILE__,
            'line' => __LINE__
        ]);

        return $logger;
    }
}
