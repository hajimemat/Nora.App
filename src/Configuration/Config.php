<?php
declare(strict_types=1);
namespace Nora\App\Configuration;

use Nora\App\Meta;

class Config implements
    ConfigInterface,
    \ArrayAccess
{
    private $data = [];

    public function merge(self $config) : self
    {
        $this->data += $config->data;
        return $this;
    }

    public function override(self $config) : self
    {
        $this->data += $config->data;
        $config = new self();
        $config->data = $this->data;
        return $config;
    }

    public function load(array $data) : self
    {
        foreach ($data as $k => $v) {
            $this->data[$k] = $v;
        }

        return $this;
    }

    public function offsetGet($name)
    {
        return $this->data[$name] ?? null;
    }

    public function offsetSet($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function offsetExists($name)
    {
        return isset($this->data[$name]);
    }

    public function offsetUnset($name)
    {
        unset($this->data[$name]);
    }
}
