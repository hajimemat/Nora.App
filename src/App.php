<?php
namespace Nora\App;

use Nora\Kernel as Base;
use Nora\Kernel\Event;
use Nora\Logging;

class App extends Base\Environment implements Event\SubscriberInterface
{
    private $FileSystem;

    public static function boot()
    {
        $kernel = new Kernel();
        return $kernel;
    }

    /**
     * 初期化
     */
    protected function initEnvironment()
    {
        $this->subscribe($this);
    }

    public function getOpt($name)
    {
        return $this->getKernal()->getOpt($name);
    }

    /**
     * イベント処理
     */
    public function accept(Event\Event $event)
    {
        switch($event->getName()) {
        case Base\Kernel::EVENT_ON_POST_BOOT:
            $this->onPostBoot();
            break;
        }
    }

    private function onPostBoot()
    {
        // PHPの処理をする
        $php = $this->configRead('php');
        if ($php['display_errors'] ?? false) {
            ini_set('display_errors', 1);
        }
        if ($php['lang'] ?? false) {
            mb_language($php['lang']);
        }
        if ($php['timezone'] ?? false) {
            date_default_timezone_set($php['timezone']);
        }

        // エラーハンドリング
        set_error_handler([$this->logger(), 'phpErrorReport']);
        set_exception_handler([$this->logger(), 'phpException']);

        // ログを設定
        $this->logger()->trace("起動準備完了");
    }

    /**
     * 設定オブジェクトを取得
     *
     * @return Modules\Configure\Config
     */
    public function config() : Modules\Configure\Config
    {
        return $this->component('config');
    }

    /**
     * 設定を取得
     *
     * @return Modules\Configure\Config
     */
    public function configRead($name)
    {
        return $this->config()->read($name);
    }

    /**
     * ロガーを取得
     *
     * @return Logging\Logger
     */
    public function logger() : Logging\Logger
    {
        return $this->component('logger');
    }
}
