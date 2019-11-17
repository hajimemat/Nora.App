<?php
declare(strict_types=1);

namespace Nora\App;


use Nora\DI\Module;
use Nora\DI\Scope;

class AppModule extends Module
{
    public function configure()
    {
        $this->install(new Provide\ConfigureModule());
        $this->install(new Provide\LoggerModule());
    }
}
