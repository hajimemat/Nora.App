<?php
declare(strict_types=1);

namespace Fake\App\Module;


use Nora\DI\Module;
use Nora\DI\Scope;
use Fake\App\Provide;

class AppModule extends Module
{
    public function configure()
    {
        $this
            ->bind(Provide\Hoge::class)
            ->toProvider(Provide\HogeProvider::class)
            ->in(Scope::SINGLETON);
    }
}
