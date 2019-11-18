<?php
declare(strict_types=1);

namespace Nora\App;

use Nora\DI\Module;

abstract class AppModule extends Module
{
    public function __construct(AppMeta $meta, $module = null)
    {
        $this->meta = $meta;
        parent::__construct($module);
    }
}
