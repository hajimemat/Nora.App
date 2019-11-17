<?php
declare(strict_types=1);

namespace Nora\App;

class Config implements Extension\ConfigInterface
{
    public function read()
    {
        return "config is loaded";
    }
}
