<?php

declare(strict_types=1);

namespace Nora\App;

use Nora\DI\Module as AbstractModule;

class Module extends AbstractModule
{
    private $meta;

    public function __construct(Meta $meta, AbstractModule $module = null)
    {
        $this->meta = $meta;
        parent::__construct($module);
    }

    public function configure()
    {
        $this->bind(Meta::class)->toInstance($this->meta);
        $this->bind(AppInterface::class)->to($this->meta->name.'\\Module\\App');
    }
}
