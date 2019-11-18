<?php
declare(strict_types=1);

namespace Nora\App\Provide\Logging;

use Psr\Log\{
    LoggerInterface
};

use Nora\Logging as Base;
use Nora\App\AppMeta;

class LoggerWriterFactory extends Base\WriterFactory
{
    private $meta;

    public function __construct(AppMeta $meta)
    {
        $this->meta = $meta;
    }

    public function __invoke(array $spec) : Base\Writer
    {
        // Writerの場合はファイル名を追加する
        if ($spec['class'] === Base\Writer\FileWriter::class) {
            $args = array_values($spec['args']);
            $args[0] = $args[0]{0} === "/" ? 
                $args[0]:
                $this->meta->logDir .'/'. $args[0];
            $spec['args'] = $args;
        }
        return parent::__invoke($spec);
    }
}
