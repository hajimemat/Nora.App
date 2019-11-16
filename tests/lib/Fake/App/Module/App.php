<?php
declare(strict_types=1);

namespace Fake\App\Module;

use Nora\App\AppInterface;
use Nora\DI\Module;
use Fake\App\Provide;

class App implements AppInterface
{
    public $hoge;

    public function __construct(
        Provide\Hoge $hoge
    ) {
        $this->hoge = $hoge;
    }
    public function configure()
    {
    }
}
