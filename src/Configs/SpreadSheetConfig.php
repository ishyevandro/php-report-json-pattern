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
            'first_column' => '',
            'header_line_position' => ''
        ];
        $this->jsonPathPrefix = 'sheets.*.config.';
        parent::__construct($data);
        if (!isset($this->config['fields']) || !\is_array($this->config['fields'])) {
            $this->config['fields'] = [];
        }

        foreach ((array) $this->config['fields'] as $key => $value) {
            $this->fields[] = new FieldConfig($this->config['fields'][$key]);
        }
    }

    public function validate(): bool
    {
        if ($this->checkKeys() === false) {
            return false;
        }

        return $this->validateFields();
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    protected function validateFields(): bool
    {
        /**
         * @var $field FieldConfig
         */
        foreach ($this->fields as $field) {
            if ($field->validate() === false) {
                $this->errorMessage = $field->getMessage();
                return false;
            }
        }

        return true;
    }
}
