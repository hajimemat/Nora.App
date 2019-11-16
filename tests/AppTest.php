<?php
namespace Nora\App;

/**
 * アプリケーションテスト
 */
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testApp()
    {
        $app = (new Bootstrap)->getApp(
            "Fake\App",
            "app-prod"
        );

        var_Dump(($app->hoge)());

        // // カーネル作成
        // $kernel = new AppKernel([
        //     'root_path' => __DIR__.'/package',
        //     'cache_path' => __DIR__.'/package/tmp',
        //     'env' => 'development'
        // ]);
        //
        // // カーネル起動
        // $app = $kernel->boot();
        //
        // // 設定がきちんと読み込めていれば
        // $this->assertEquals(
        //     'サンプルアプリケーション',
        //     $app->configRead('application.name')
        // );
    }
}
