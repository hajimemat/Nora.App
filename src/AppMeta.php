<?php
declare(strict_types=1);

namespace Nora\App;


class AppMeta 
{
    public $name;
    public $context;
    public $appDir;
    public $tmpDir;
    public $logDir;

    public function __construct(string $name, string $context, string $appDir)
    {
        $this->name = $name;
        $this->context = $context;
        $this->appDir = $appDir ?: 
            dirname(
                (string)(new \ReflectionClass($name.'\Module\AppModule'))
                    ->getFileName(), 3
            );
        $this->tmpDir = $this->appDir . '/var/tmp/' . $context;
        if (!is_writable($this->tmpDir)) {
            if (!mkdir($this->tmpDir, 0777, true) && !isDir($this->tmpDir)) {
                throw new NotWritableException($this->tmpDir);
            }
        }
        $this->logDir = $this->appDir . '/var/log/' . $context;
        if (!is_writable($this->logDir)) {
            if (!mkdir($this->logDir, 0777, true) && !isDir($this->logDir)) {
                throw new NotWritableException($this->logDir);
            }
        }
    }

    public function name() : string
    {
        return $this->name;
    }

    public function appDir() : string
    {
        return $this->appDir;
    }

    public function tmpDir() : string
    {
        return $this->tmpDir;
    }

    public function logDir() : string
    {
        return $this->logDir;
    }
}
