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
            "app-prod",
            __DIR__."/package"
        );

        // Singleton
        $this->assertSame($app->config, $app->config);

        var_Dump(APP_DEBUG_HOGE);
    }
}
