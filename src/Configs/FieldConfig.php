<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

use IshyEvandro\XlsPatternGenerator\Interfaces\IFieldGetPosition;
use IshyEvandro\XlsPatternGenerator\Interfaces\IFieldGetRowKey;

class FieldConfig extends AbstractConfig implements IFieldGetPosition, IFieldGetRowKey
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

    public function getRowKey(): string
    {
        return (string) $this->config['json_row_key'];
    }

    public function getPosition(): string
    {
        return (string) $this->config['position'];
    }
}
