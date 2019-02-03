<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

class SpreadSheetConfig extends AbstractConfig
{
    public function __construct(array $data)
    {
        $this->expectedConfig = [
            'fields' => [],
            'first_column' => '',
            'header_line_position' => ''
        ];
        $this->jsonPathPrefix = 'sheets.*.config.';
        parent::__construct($data);
    }

    public function validate(): bool
    {
        return $this->checkKeys();
    }
}
