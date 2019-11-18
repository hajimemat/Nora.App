<?php
declare(strict_types=1);
namespace Nora\App\Provide\Configure;

use Nora\App\Meta;

interface ConfigureInterface
{
    public function configure() : Config;
}
