<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Psr\Log\{
    LoggerInterface
};

use Nora\Logging;

class LoggerWriterFactory extends Logging\WriterFactory
{
    private $meta;

    public function __construct(\Nora\App\Meta $meta)
    {
        $this->meta = $meta;
    }

    public function __invoke(array $spec) : Logging\Writer
    {
        // Writerの場合はファイル名を追加する
        if ($spec['class'] === Logging\Writer\FileWriter::class) {
            $args = array_values($spec['args']);
            $args[0] = $args[0]{0} === "/" ? 
                $args[0]:
                $this->meta->logDir .'/'. $args[0];
            $spec['args'] = $args;
        }
        return parent::__invoke($spec);
    }
}
