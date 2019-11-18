<?php
declare(strict_types=1);
namespace Nora\App\Configuration;

use Nora\App\Meta;

use Psr\Log\LoggerInterface;
use Nora\Logging\LogLevel;
use Nora\Logging\LogFactory;

class ErrorHandling
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * エラーログを管理する
     */
    public function __invoke(bool $flag)
    {
        if ($flag === false) {
            return false;
        }
        set_error_handler([$this, 'phpErrorReport']);
        set_exception_handler([$this, 'phpExceptionReport']);
        register_shutdown_function([$this, 'phpFatalError']);
        return true;
    }

    /**
     * PHPのエラーをログに変換する
     */
    public function phpErrorReport($eno, $emsg, $efile, $eline)
    {
        $this->logger->log(
            LogLevel::convertPHPErrorNo($eno),
            $emsg,
            [
                "php_error_file" => $efile,
                "php_error_line" => $eline
            ]
        );
    }

    /**
     * エラー終了時にログを設定する
     */
    public function phpFatalError()
    {
        $last_error = error_get_last();
        if ($last_error['type'] === E_ERROR) {
            $this->phpErrorReport(
                $last_error['type'],
                $last_error['message'],
                $last_error['file'],
                $last_error['line']
            );
        }
    }

    /**
     * PHPのエクセプションをログに変換する
     */
    public function phpExceptionReport(\Throwable $exception)
    {
        $level = LogLevel::LEVEL_ERROR;
        if ($exception instanceof LoggableExceptionInterface) {
            $level = $exception->getPriority();
        }

        $this->logger->log(
            $level,
            sprintf('(%s) %s', get_class($exception), $exception->getMessage()),
            [
                "file" => (string) $exception->getFile(),
                "line" => (string) $exception->getLine(),
                "trace" => explode("\n", $exception->getTraceAsString())
            ]
        );
    }
}
