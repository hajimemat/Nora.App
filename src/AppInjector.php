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
        AppMeta $meta = null,
        string $cacheNamespace = null
    ) {
        $this->context = $context;
        $this->meta = $meta instanceof AppMeta ?
            $meta: new AppMeta($name, $context);
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

        $module = (new ModuleFactory)($this->meta, $this->context);
        (new Bind($module->getContainer(), InjectorInterface::class))->toInstance($this);

        return $module;
    }

}
