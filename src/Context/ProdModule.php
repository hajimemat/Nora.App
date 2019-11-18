<?php
declare(strict_types=1);
namespace Nora\App\Context;

use Nora\DI\Module;
use Nora\App\Provide;

class ProdModule extends Module
{
    public function configure()
    {
        // $this->install(new Provide\CacheModule());
    }
}
