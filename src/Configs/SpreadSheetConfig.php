<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

class SpreadSheetConfig extends AbstractConfig
{
    protected $fields = [];

    public function __construct(array &$data)
    {
        $this->expectedConfig = [
            'fields' => [],
            'header_line_position' => ''
        ];
        $this->jsonPathPrefix = 'sheets.*.config.';
        parent::__construct($data);
        if (!isset($this->config['fields']) || !\is_array($this->config['fields'])) {
            $this->config['fields'] = [];
        }

        foreach ((array) $this->config['fields'] as &$value) {
            $this->fields[] = new FieldConfig($value);
        }
    }

    public function validate(): bool
    {
        if ($this->checkKeys($this->expectedConfig, $this->config, $this->jsonPathPrefix) === false) {
            $this->setErrorMessage($this->getKeyError());
            return false;
        }

        return $this->validateFields();
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getHeaderLinePosition(): int
    {
        return (int) $this->config['header_line_position'];
    }

    protected function validateFields(): bool
    {
        /**
         * @var $field FieldConfig
         */
        foreach ($this->fields as $field) {
            if ($field->validate() === false) {
                $this->setErrorMessage($field->getErrorMessage());
                return false;
            }
        }

        return true;
    }
}
