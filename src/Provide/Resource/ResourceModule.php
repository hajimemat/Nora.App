<?php
declare(strict_types=1);

namespace Nora\App\Provide\Resource;

use Nora\DI\Module;
use Nora\DI\Scope;

/**
 * リソースモジュール
 */
class ResourceModule extends Module
{
    public function configure()
    {
        $this
            ->bind(ResourceRepositoryInterface::class)
            ->to(ResourceRepository::class);
    }
}
