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
        // カーネル作成
        $kernel = new AppKernel([
            'root_path' => __DIR__.'/resource',
            'cache_path' => __DIR__.'/resource/tmp',
            'env' => 'development'
        ]);

        // カーネル起動
        $app = $kernel->boot();

        // 設定がきちんと読み込めていれば
        $this->assertEquals(
            'サンプルアプリケーション',
            $app->configRead('application.name')
        );
    }
}
