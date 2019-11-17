<?php
declare(strict_types=1);

namespace Nora\App\Provide;

use Psr\Log\{
    LoggerInterface
};

use Nora\Logging;
use Nora\Logging\FormatterFactory;
use Nora\Logging\FilterFactory;

class LoggerFactory extends Logging\LoggerFactory
{
    private $writerFactory;

    public function __construct(Logging\WriterFactory $writerFactory)
    {
        $this->writerFactory = $writerFactory;
    }

    public function __invoke($spec) : Logging\Logger
    {
        $Logger = new Logging\Logger();

        foreach ($spec['writers'] as $writer) {
            $Writer = ($this->writerFactory)([
                'class' => $writer['class'],
                'args' => $writer['args']
            ]);
            // フォーマットをセット
            $Writer->setFormatter((new FormatterFactory)($writer['formatter']));
            $Writer->setFilter((new FilterFactory)($writer['filter']));

            $Logger->addWriter($Writer);
        }
        return $Logger;
    }
}
