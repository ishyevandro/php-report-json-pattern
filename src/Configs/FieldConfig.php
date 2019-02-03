<?php
declare(strict_types = 1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

class FieldConfig extends AbstractConfig
{
    public function __construct(array $data)
    {
        $this->jsonPathPrefix = 'sheets.*.config.fields.*.';
        $this->expectedConfig = [
            'name' => '',
            'position' => '',
            'type' => '',
            'json_row_key' => ''
        ];
        parent::__construct($data);
    }

    public function validate(): bool
    {
        return $this->checkKeys();
    }
}
