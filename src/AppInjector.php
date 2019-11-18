<?php
declare(strict_types=1);

namespace Nora\App;

use Nora\App\Exception\InvalidContext;
use Nora\DI\InjectorInterface;
use Nora\DI\Injector;
use Nora\DI\Name;
use Nora\DI\Bind;
use Nora\DI\Module as AbstractModule;
use Nora\DI\NullModule;

class AppInjector implements InjectorInterface
{
    private $context;
    private $meta;
    private $cacheNamespace;
    private $tmpDir;
    private $module;

    public function __construct(
        string $name,
        string $context,
        Meta $meta = null,
        string $cacheNamespace = null
    ) {
        $this->context = $context;
        $this->meta = $meta instanceof Meta ?
            $meta: new Meta($name, $context);
        $this->tmpDir = $this->meta->tmpDir();
        $this->injector = new Injector($this->getModule());
    }

    public function getInstance(string $interface)
    {
        return $this->injector->getInstance($interface);
    }

    public function getCachedInstance($interface, $name = Name::ANY)
    {
        // $cache = new FilesystemCache($this->appDir);
        // $id = $interface . $name . $this->context . $this->cacheNamespace;
        // $instance = $cache->fetch($id);
        // if ($instance) {
        //     return $instance;
        // }
        $instance = $this->injector->getInstance($interface, $name);
        // $cache->save($id, $instance);
        return $instance;
    }

    public function getModule() : AbstractModule
    {
        if ($this->module instanceof AbstractModule) {
            return $this->module;
        }

        $contextsArray = array_reverse(
            explode(
                '-',
                $this->context
            )
        );

        $module = new NullModule();

        foreach ($contextsArray as $contextItem) {
            $class = $this->meta->name . '\\Module\\' . ucwords($contextItem) . 'Module';
            if (!class_exists($class)) {
                $class = 'Nora\\App\\Context\\' . ucwords($contextItem) . "Module";
            }

            if (!is_a($class, AbstractModule::class, true)) {
                throw new InvalidContext($contextItem);
            }

            $module = is_subclass_of($class, AppModule::class) ?
                new $class($this->meta, $module):
                new $class($module);
        }

        if (!$module instanceof AbstractModule) {
            throw new InvalidModule;
        }

        $module->override(new Module($this->meta));

        (new Bind($module->getContainer(), InjectorInterface::class))->toInstance($this);

        return $module;

    }

}
