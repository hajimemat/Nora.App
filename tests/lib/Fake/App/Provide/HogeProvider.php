<?php
declare(strict_types=1);

namespace Fake\App\Provide;


use Nora\DI\ProviderInterface;
use Nora\App\Meta;

class HogeProvider implements ProviderInterface
{
    private $meta;

    public function __construct(Meta $meta)
    {
        $this->meta = $meta;
    }

    public function get()
    {
        return new Hoge($this->meta);
    }
}
