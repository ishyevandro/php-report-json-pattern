<?php

namespace IshyEvandro\XlsPatternGenerator\Configs;

/**
 * Class WorksheetConfig
 * @package IshyEvandro\XlsPatternGenerator\Configs
 */
class WorksheetConfig
{
    /**
     * @var
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->validateConfig();
    }

    /**
     *
     */
    protected function validateConfig()
    {

    }
}
