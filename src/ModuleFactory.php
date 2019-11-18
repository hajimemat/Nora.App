<?php
declare(strict_types=1);

namespace Nora\App;

use Nora\DI\Module as AbstractModule;
use Nora\DI\NullModule;

class ModuleFactory
{
    public function __invoke(AppMeta $meta, string $context) : AbstractModule
    {
        $contextsArray = array_reverse(
            explode(
                '-',
                $context
            )
        );

        $module = new NullModule();

        foreach ($contextsArray as $contextItem) {
            $class = $meta->name . '\\Module\\' . ucwords($contextItem) . 'Module';
            if (!class_exists($class)) {
                $class = 'Nora\\App\\Context\\' . ucwords($contextItem) . "Module";
            }

            if (!is_a($class, AbstractModule::class, true)) {
                throw new InvalidContext($contextItem);
            }

            $module = is_subclass_of($class, AppModule::class) ?
                new $class($meta, $module):
                new $class($module);
        }

        if (!$module instanceof AbstractModule) {
            throw new InvalidModule;
        }

        $module->override(new AppMetaModule($meta));

        return $module;
    }
}
