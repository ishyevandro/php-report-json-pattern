<?php

namespace IshyEvandro\XlsPatternGenerator\Processors;

use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class WorksheetConfig
 * @package IshyEvandro\XlsPatternGenerator\Configs
 */
class WorksheetProcessor
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

    /**
     * @var Worksheet
     */
    protected $worksheet;

    protected $column = null;
    protected $line = 0;
    /**
     * WorksheetProcessor constructor.
     * @param array $config
     * @throws XlsPatternGeneratorException
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->setConfig();
    }

    public function process(Worksheet $worksheet, &$sheetInfo): bool
    {
        $this->worksheet = $worksheet;
        $this->setHeader()
            ->processData($sheetInfo);
        return true;
    }

    /**
     * @return $this
     */
    protected function setHeader()
    {
        $this->setFirstColumn();
        $this->setFirstLine();
        foreach ($this->config['fields'] as $field) {
            $this->setCellValue($field)
                ->nextColumn();
        }

        $this->nextLine();
        return $this;
    }

    protected function processData(&$sheetInfo)
    {
        foreach ($sheetInfo["data"] as $row) {
            $this->processOneRow($row);
        }
    }

    protected function processOneRow(&$row): bool
    {
        $this->setFirstColumn();
        foreach ($row as $value) {
            $this->setCellValue($value)
                ->nextColumn();
        }

        $this->nextLine();
        return true;
    }

    /**
     * @param $value
     * @return WorksheetProcessor
     */
    protected function setCellValue(&$value): self
    {
        $this->worksheet->setCellValue($this->column.$this->line, $value);
        return $this;
    }

    /**
     * @return bool
     * @throws XlsPatternGeneratorException
     */
    protected function setConfig(): bool
    {
        foreach ($this->expectConfigFields as $field) {
            $this->checkField($field);
        }
        $this->setFirstColumn()
            ->setFirstLine();
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

    /**
     * @return WorksheetProcessor
     */
    protected function setFirstColumn(): self
    {
        $this->column = $this->config['first_column'];
        return $this;
    }

    /**
     * @return WorksheetProcessor
     */
    protected function setFirstLine(): self
    {
        $this->line = ($this->config['header_line']*1);
        $this->line = $this->line > 0 ? $this->line : 1;
        return $this;
    }

    /**
     * @return WorksheetProcessor
     */
    protected function nextColumn(): self
    {
        if ($this->column == 'Z') {
            $this->column = $this->column. "A";
            return $this;
        }

        $this->column++;
        return $this;
    }

    /**
     * @return WorksheetProcessor
     */
    protected function nextLine(): self
    {
        $this->line++;
        return $this;
    }
}
