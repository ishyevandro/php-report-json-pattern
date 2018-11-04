<?php

namespace IshyEvandro\XlsPatternGenerator\Configs;

use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;

/**
 * Class WorksheetConfig
 * @package IshyEvandro\XlsPatternGenerator\Configs
 */
class WorksheetConfig
{
    protected $expectConfigFields = [
        "fields",
        "header_line",
        "first_column"
    ];
    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->validateConfig();
    }

    /**
     * @return bool
     * @throws XlsPatternGeneratorException
     */
    protected function validateConfig(): bool
    {
        foreach ($this->expectConfigFields as $field) {
            $this->checkField($field);
        }
        return true;
    }

    /**
     * @param $field
     * @return bool
     * @throws XlsPatternGeneratorException
     */
    protected function checkField($field): bool
    {
        if (!array_key_exists($field, $this->config)) {
            throw new XlsPatternGeneratorException(
                "key [$field] not exist in sheet configuration"
            );
        }
        return true;
    }
}
