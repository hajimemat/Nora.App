<?php
declare(strict_types=1);
namespace Nora\App\Context;

use Nora\DI\Module;

use Nora\App;
use Nora\System;
use Nora\Routing;
use Nora\Http;

use Psr\Http\Message\ResponseInterface;
use Nora\Http\Message\Response;


/**
 * アプリケーションで必要となるモジュールの読み込み
 */
class AppModule extends Module
{
    public function configure()
    {
        // $this->Install(new App\AppModule());
        // $this->Install(new System\Provide\UuidModule());
        // $this->install(new Http\Provide\ServerRequestModule());
        // $this->Install(new Routing\Provide\RouterModule());
        // $this->install(new App\Provide\Front\FrontModule());
        //
        // $this->bind(ResponseInterface::class)
        //     ->to(Response::class);
    }
}
