<?php
declare(strict_types=1);

namespace Nora\App;

use Nora\DI\Module;

class AppMetaModule extends Module
{
    public function __construct(AppMeta $meta, $module = null)
    {
        $this->meta = $meta;
        parent::__construct($module);
    }

    public function configure()
    {
        $this->bind(AppMeta::class)->toInstance($this->meta);
        $this->bind(AppInterface::class)->to($this->meta->name . '\\Module\\App');
    }
}
