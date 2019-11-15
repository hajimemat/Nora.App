<?php
namespace Nora\App\Modules\Logging;

use Nora\Kernel as Base;
use Nora\Filter\Collection;
use Nora\Logging;

/**
 * 設定モジュール
 */
class Module extends Base\Module
{
    public function getName() : string
    {
        return 'logging';
    }

    /**
     * 設定をする
     */
    public function configure(Base\Environment $env, array &$data)
    {
        $file = $env->getKernel()->getConfigFile('logging.yml');

        // 設定を追加する
        $data['logging'] = $file->parseYaml();
    }

    public function onAdd(Base\Kernel $kernel)
    {
        // コンフィグ用のファクトリを設定
        $kernel->addFactory(
            new class extends Base\Factory {
                public static function getName() : string
                {
                    return "logger";
                }
                public function create(Base\Environment $env, array $options = [])
                {
                    $name = $env->configRead('logging.default');
                    $handlers = $env->configRead("logging.handlers.{$name}");
                    $logger = new Logging\Logger();
                    foreach ($handlers as $handler) {
                        $logger->setHandler(Logging\Handler::create($handler));
                    }
                    return $logger;
                }
            }
        );
    }
}
