<?php
declare(strict_types=1);
namespace Nora\App\Context;

use Nora\DI\Module;


use Nora\App\Provide\Web\WebRequestModule;

/**
 * Webで必要になるもの
 */
class WebModule extends Module
{
    public function configure()
    {
        $this->install(new WebRequestModule());
    }
}
