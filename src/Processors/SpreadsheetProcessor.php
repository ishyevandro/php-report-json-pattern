<?php

namespace IshyEvandro\XlsPatternGenerator\Processors;

use IshyEvandro\XlsPatternGenerator\Configs\FieldConfig;
use IshyEvandro\XlsPatternGenerator\Configs\SpreadSheetConfig;
use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use IshyEvandro\XlsPatternGenerator\Interfaces\{
    ICheckKeys,
    IErrorMessage
};
use IshyEvandro\XlsPatternGenerator\Messages\Messages;
use IshyEvandro\XlsPatternGenerator\Traits\{
    CheckKeysTrait,
    ErrorMessageTrait
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class WorksheetConfigWIP
 * @package IshyEvandro\XlsPatternGenerator\Configs
 */
class SpreadsheetProcessor implements IErrorMessage, ICheckKeys
{
    use ErrorMessageTrait, CheckKeysTrait;

    /**
     * @var Worksheet
     */
    protected $worksheet;

    protected $column;
    protected $line = 0;
    protected $spreadsheetData = [];
    /**
     * @var SpreadSheetConfig
     */
    protected $config;

    protected $expectedFields = [
        'config' => [],
        'data' => []
    ];

    protected $jsonPathPrefix = 'sheets.*.';

    /**
     * SpreadsheetProcessor constructor.
     * @param array $spreadsheetData
     */
    public function __construct(array &$spreadsheetData)
    {
        $this->spreadsheetData = $spreadsheetData;
        $this->setConfig();
    }

    public function validate(): bool
    {
        $return = true;
        if ($this->checkKeys($this->expectedFields, $this->spreadsheetData, $this->jsonPathPrefix)) {
            $this->setErrorMessage($this->getKeyError());
            $return = false;
        }

        if ($return === true && $this->config->validate() === false) {
            $this->setErrorMessage($this->config->getErrorMessage());
        }

        return true;
    }

    public function setWorksheet(Worksheet $worksheet): self
    {
        $this->worksheet = $worksheet;
        return $this;
    }

    /**
     * @return SpreadsheetProcessor
     */
    public function setFirstLine(): self
    {
        $this->line = $this->config->getHeaderLinePosition();
        $this->line = $this->line > 0 ? $this->line : 1;
        return $this;
    }

    /**
     * @return $this
     */
    public function setHeader(): self
    {
        /**
         * @var $field FieldConfig
         */
        foreach ($this->config->getFields() as $field) {
            $this->setCellValue($field->getColumn(), $field->getFieldName());
        }

        $this->nextLine();
        return $this;
    }

    /**
     * @return bool
     */
    public function process(): bool
    {
        $this->processData();
        return true;
    }

    protected function processData(): void
    {
        $fields = $this->config->getFields();
        foreach ((array) $this->spreadsheetData['data'] as &$row) {
            $this->processOneRow($fields, $row);
        }
    }

    /**
     * @param array $fields
     * @param array $row
     * @return bool
     * @throws XlsPatternGeneratorException
     */
    protected function processOneRow(array &$fields, array &$row): bool
    {
        /**
         * @var $field FieldConfig
         */
        foreach ($fields as $field) {
            try {
                $value = $row[$field->getRowKey()];
            } catch (\Exception $e) {
                throw new XlsPatternGeneratorException(
                    Messages::getMessage(
                        Messages::FIELD_NOT_FOUND,
                        [
                            '{line}' => $this->line,
                            '{prop}' => $field->getRowKey()
                        ]
                    )
                );
            }

            $this->setCellValue($field->getColumn(), $value);
        }

        $this->nextLine();
        return true;
    }

    /**
     * @param $column
     * @param $value
     * @return SpreadsheetProcessor
     */
    protected function setCellValue($column, $value): self
    {
        $this->worksheet->setCellValue($column.$this->line, $value);
        return $this;
    }

    protected function setConfig(): void
    {
        $this->config = new SpreadSheetConfig($this->spreadsheetData['config']);
    }

    /**
     * @return SpreadsheetProcessor
     */
    protected function nextLine(): self
    {
        $this->line++;
        return $this;
    }
}
