<?php
declare(strict_types=1);

namespace Nora\App\Provide\Domain;

use Nora\DI\Module;
use Nora\DI\Scope;

/**
 * テンプレート
 */
abstract class Templates
{
    const ENTITY_CLASS_CODE = <<<'CODE'
<?php
namespace A6tSpace;

use Nora\Domain\Entity;

/**
 * this is Entity
 */
class A6tEntity extends Entity
{
    public function __construct()
    {
    }

    public function __set($name, $value)
    {
        if ($this->{$name}) {
            $this->{$name} = ($this->{$name . "Factory"})($value);
        }
    }

    public function __get($name)
    {
        return $this->{$name};
    }
}

CODE;

    const VALUE_OBJECT_CLASS_CODE = <<<'CODE'
<?php
namespace A6tSpace;

use Nora\Domain\ValueObject;

/**
 * this is Entity
 */
class A6tValueObject extends ValueObject
{
}
CODE;
}
