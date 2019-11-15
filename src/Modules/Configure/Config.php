<?php
namespace Nora\App\Modules\Configure;

use Nora\Filter\Collection;

/**
 * 設定
 */
class Config implements \ArrayAccess
{
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function offsetGet($name)
    {
        return $this->read($name);
    }

    public function offsetExists($name)
    {
        return $this->has($name);
    }

    public function offsetSet($name, $value)
    {
        $this->write($name, $value);
    }

    public function offsetUnset($name)
    {
        $this->del($name);
    }

    public function read($name)
    {
        return Collection::findValue($this->data, $name);
    }


}
