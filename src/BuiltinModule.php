<?php
declare(strict_types=1);

namespace Nora\App;


use Nora\DI\Module as Base;

class BuiltinModule extends Base
{
    public function configure()
    {
        // コンフィギュレーションモジュール
        $this->install(new Provide\Configure\ConfigureModule());
        // キャッシュモジュール
        $this->install(new Provide\Cache\SimpleCacheModule());
        // ロガーモジュール
        $this->install(new Provide\Logging\LoggerModule());
        // ルーティングモジュール
        $this->install(new Provide\Routing\RoutingModule());
        // リソースモジュール
        $this->install(new Provide\Resource\ResourceModule());
        // ドメインモジュール
        $this->install(new Provide\Domain\DomainModule());
    }
}
