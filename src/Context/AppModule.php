<?php
declare(strict_types=1);
namespace Nora\App\Context;

use Nora\DI\Module;

use Nora\App\AppModule as Base;
use Nora\System;
use Nora\Routing;

class AppModule extends Module
{
    public function configure()
    {
        $this->Install(new Base());
        $this->Install(new System\Provide\UuidModule());
    }
}
