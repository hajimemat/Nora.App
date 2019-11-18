<?php
declare(strict_types=1);

namespace Nora\App\Provide\Logging;

use Psr\Log\LoggerInterface;

use Nora\DI\ProviderInterface;

use Nora\App\AppMeta;

use Nora\App\Provide\Configure\ConfigInterface;
use Nora\Logging\WriterFactory;

class LoggerProvider implements ProviderInterface
{
    private $meta;

    public function __construct(
        AppMeta $meta,
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
