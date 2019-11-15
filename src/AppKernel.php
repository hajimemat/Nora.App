<?php
namespace Nora\App;

use Nora\Kernel as Base;
use Nora\System\FileSystem;

/**
 * アプリケーション用のカーネル
 */
class AppKernel extends Base\Kernel
{
    private $FileSystem;

    protected function createEnvironment() : Base\Environment
    {
        return new App($this);
    }

    protected function initKernel()
    {
        parent::initKernel();

        if (!defined('APP_PROJECT_PATH')) {
            define('APP_PROJECT_PATH', $this->getOpt('root_path'));
        }

        $this->FileSystem = FileSystem::entry($this->getOpt('root_path'));

        $modules = [
            Modules\Configure\Module::class,
            Modules\Logging\Module::class
        ];

        foreach ($modules as $module) {
            $this->addModule(new $module());
        }
    }

    /**
     * コンフィグファイルを取得
     */
    public function getConfigFile(...$path)
    {
        return $this->FileSystem->getFile("config", $path);
    }

    /**
     * プロジェクトのファイルを取得
     */
    public function getFile(...$path)
    {
        return $this->FileSystem->getFile($path);
    }
}
