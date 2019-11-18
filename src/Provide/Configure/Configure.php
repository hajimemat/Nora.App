<?php
declare(strict_types=1);
namespace Nora\App\Provide\Configure;

use Nora\App\AppMeta as Meta;

class Configure implements ConfigureInterface
{
    private $config;

    public function __construct(Meta $meta, $context)
    {
        $this->config = new Config();
        $this->getConfigFile($meta, $context);
    }

    private function getConfigFile(Meta $meta, $context)
    {
        $file = sprintf(
            "%s/config/%s.yml",
            $meta->appDir,
            $context
        );

        if (file_exists($file)) {
            $result = yaml_parse_file($file, $pos = 0, $ndocs);
            if ($result) {
                $this->config->load($result);
            }
        }
    }

    public function configure() : Config
    {
        return $this->config;
    }
}
