<?php
declare(strict_types=1);

namespace Fake\App\Provide;


use Nora\App\Meta;

class Hoge
{
    private $meta;

    public function __construct(Meta $meta)
    {
        $this->meta = $meta;
    }

    public function __invoke()
    {
        return $this->meta->name . " is Hoge";
    }
}
