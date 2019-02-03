<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

use IshyEvandro\XlsPatternGenerator\Interfaces\IFieldGetPosition;
use IshyEvandro\XlsPatternGenerator\Interfaces\IFieldGetRowKey;
use IshyEvandro\XlsPatternGenerator\Messages\Messages;

class FieldConfig extends AbstractConfig implements IFieldGetPosition, IFieldGetRowKey
{
    public const ACCEPTABLE_TYPES = 'string|number';

    public function __construct(array $data)
    {
        $this->jsonPathPrefix = 'sheets.*.config.fields.*.';
        $this->expectedConfig = [
            'name' => '',
            'position' => '',
            'type' => self::ACCEPTABLE_TYPES,
            'json_row_key' => ''
        ];
        parent::__construct($data);
    }

    public function validate(): bool
    {
        if ($this->checkKeys() === false) {
            return false;
        }

        if ($this->checkType() === false) {
            return false;
        }

        return true;
    }

    public function getRowKey(): string
    {
        return (string) $this->config['json_row_key'];
    }

    public function getPosition(): string
    {
        return (string) $this->config['position'];
    }

    protected function checkType(): bool
    {
        $expected = explode('|', $this->expectedConfig['type']);
        if (\in_array($this->config['type'], $expected, true) === false) {
            $this->errorMessage = Messages::getMessage(
                Messages::CONFIG_FIELD_TYPE_ERROR,
                [
                    '{wrong}' => $this->config['type'],
                    '{types}' => self::ACCEPTABLE_TYPES
                ]
            );
            return false;
        }

        return true;
    }
}
