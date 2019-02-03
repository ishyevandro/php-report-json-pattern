<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

use IshyEvandro\XlsPatternGenerator\Interfaces\{
    IFieldGetColumn,
    IFieldGetRowKey
};
use IshyEvandro\XlsPatternGenerator\Messages\Messages;

class FieldConfig extends AbstractConfig implements
    IFieldGetColumn,
    IFieldGetRowKey
{
    public const ACCEPTABLE_TYPES = 'string|number';

    public function __construct(array &$data)
    {
        $this->jsonPathPrefix = 'sheets.*.config.fields.*.';
        $this->expectedConfig = [
            'name' => '',
            'column' => '',
            'type' => self::ACCEPTABLE_TYPES,
            'json_row_key' => ''
        ];
        parent::__construct($data);
    }

    public function validate(): bool
    {
        $return = true;
        $checkKeys = $this->checkKeys($this->expectedConfig, $this->config, $this->jsonPathPrefix);
        if ($checkKeys === false) {
            $this->setErrorMessage($this->getKeyError());
            $return = false;
        }

        if ($return === true && $this->checkType() === false) {
            $return = false;
        }

        return $return;
    }

    public function getRowKey(): string
    {
        return (string) $this->config['json_row_key'];
    }

    public function getColumn(): string
    {
        return (string) $this->config['column'];
    }

    public function getFieldName(): string
    {
        return $this->config['name'];
    }

    protected function checkType(): bool
    {
        $expected = explode('|', $this->expectedConfig['type']);
        if (\in_array($this->config['type'], $expected, true) === false) {
            $this->setErrorMessage(
                Messages::getMessage(
                    Messages::CONFIG_FIELD_TYPE_ERROR,
                    [
                        '{wrong}' => $this->config['type'],
                        '{types}' => self::ACCEPTABLE_TYPES
                    ]
                )
            );
            return false;
        }

        return true;
    }
}
