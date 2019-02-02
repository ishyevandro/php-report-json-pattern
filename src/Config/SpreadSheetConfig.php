<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Config;

use IshyEvandro\XlsPatternGenerator\Messages\Messages;

class SpreadSheetConfig extends AbstractConfig
{
    protected $expectedConfig = [
        'fields' => [],
        'first_column' => '',
        'header_line_position' => ''
    ];

    protected $jsonPathPrefix = 'sheets.*.config.';

    public function validate(): bool
    {
        foreach ($this->expectedConfig as $config => $parameters) {
            if (!\array_key_exists($config, $this->config)) {
                $this->errorMessage = Messages::getMessage(Messages::CONFIG_MISSING_FIELD, [
                    '{field}' => $this->jsonPathPrefix . $config
                ]);
                return false;
            }
        }

        return true;
    }
}
