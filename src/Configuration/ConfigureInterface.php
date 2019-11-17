<?php
declare(strict_types=1);
namespace Nora\App\Configuration;

use Nora\App\Meta;

interface ConfigureInterface
{
    public function configure() : Config;
}
