<?php
declare(strict_types=1);

namespace Nora\App\Provide\Logging;

use Psr\Log\{
    LoggerInterface
};

use Nora\Logging as Base;
use Nora\Logging\FormatterFactory;
use Nora\Logging\FilterFactory;

class LoggerFactory extends Base\LoggerFactory
{
    private $writerFactory;

    public function __construct(Base\WriterFactory $writerFactory)
    {
        $this->writerFactory = $writerFactory;
    }

    public function __invoke($spec) : Base\Logger
    {
        $Logger = new Base\Logger();

        if ($spec['writers']) {
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
        }
        return $Logger;
    }
}
