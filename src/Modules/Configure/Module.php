<?php
namespace Nora\App\Modules\Configure;

use Nora\Kernel as Base;
use Nora\Filter\Collection;
use Nora\System\FileSystem;

/**
 * 設定モジュール
 */
class Module extends Base\Module
{
    public function getName() : string
    {
        return 'configure';
    }

    public function onAdd(Base\Kernel $kernel)
    {
        parent::onAdd($kernel);
    }

    public function onPreBoot(Base\Environment $env)
    {
        // キャッシュファイル処理
        $cache_path = FileSystem::entry($env->getKernel()->getOpt('cache_path'));
        $cache_file = $cache_path->getFile('config.cache');

        // 開発中フラグ
        if ($env->getKernel()->getOpt('env') === 'development') {
            $cache_file->unlink();
        }

        // ファイルが存在しなければ
        if (!$cache_file->exists()) {
            // 設定読み込み
            $file = $env->getKernel()->getConfigFile('application.yml');
            $config_dir = FileSystem::entry(dirname($file));

            // Yamlをパースする
            $data = $file->parseYaml();

            // 作業に必要なデータを取り出す
            $work = Collection::filter([
                "config.files" => "array"
            ], $data);

            // 追加ファイルを読み出す
            foreach ($work['config']['files'] as $key => $file) {
                $file = $config_dir->getFile($file);
                $data[$key] = $file->parseYaml();
            }

            // 他のモジュール設定を読み込む
            foreach ($env->getKernel()->getModules() as $module) {
                if (method_exists($module, 'configure')) {
                    $module->configure($env, $data);
                }
            }

            // キャッシュを書き込む
            $cache_file->putContents(serialize($data));
        }

        // 設定値
        $data = unserialize($cache_file->getContents());

        // コンフィグ用のファクトリを設定
        $env->getKernel()->addFactory(
            new class($data) extends Base\Factory {
                public function __construct($data) {
                    $this->data = $data;
                }
                public static function getName() : string
                {
                    return "config";
                }
                public function create(Base\Environment $env, array $options = [])
                {
                    return new Config($this->data);
                }
            }
        );
    }

    /**
     * 設定をする
     */
    public function configure(Base\Environment $env, array &$data)
    {
        $data['hihi'] = 'AA';
    }
}
