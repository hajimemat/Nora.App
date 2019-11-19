<?php
declare(strict_types=1);

namespace Nora\App\Provide\Domain;

use Nora\DI\Module;
use Nora\DI\Scope;

/**
 * ドメインモジュール
 */
class DomainModule extends Module
{
    public function configure()
    {
        $this
            ->bind(DomainRepositoryInterface::class)
            ->to(DomainRepository::class);
    }
}
