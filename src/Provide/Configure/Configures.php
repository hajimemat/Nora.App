<?php
declare(strict_types=1);
namespace Nora\App\Provide\Configure;

class Configures implements ConfigureInterface
{
    private $configures;

    /**
     * @param Configure[]
     */
    public function __construct(array $configures)
    {
        $this->configures = $configures;
    }

    public function configure() : Config
    {
        // 全コンテクスト分の設定を読み込む
        $config = new NullConfig();
        foreach ($this->configures as $configure)
        {
            $config->merge($configure->configure());
        }

        $config = (new Config)->override($config);
        return $config;
    }
}
