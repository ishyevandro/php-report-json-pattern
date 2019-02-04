<?php

namespace IshyEvandro\XlsPatternGenerator;

use IshyEvandro\XlsPatternGenerator\Configs\SpreadSheetConfig;
use IshyEvandro\XlsPatternGenerator\Interfaces\IErrorMessage;
use IshyEvandro\XlsPatternGenerator\Processors\SpreadsheetProcessor;
use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use IshyEvandro\XlsPatternGenerator\Traits\ErrorMessageTrait;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Exception;

class XlsPatternGenerator implements IErrorMessage
{
    use ErrorMessageTrait;

    /**
     * @var Spreadsheet
     */
    protected $spreedsheet;

    /**
     * @var Worksheet
     */
    protected $currentSheet;

    /**
     * @var SpreadsheetProcessor
     */
    protected $currentWorksheetConfig;

    protected $withHeader = true;

    /**
     * XlsPatternGenerator constructor.
     * @param array $json
     */
    public function __construct(array $json)
    {
        $this->json = $json;
        $this->spreedsheet = new Spreadsheet();
    }

    /**
     * @return bool
     * @throws XlsPatternGeneratorException
     */
    public function process($withHeader = true): bool
    {
        $this->withHeader = $withHeader;
        return $this->processSheets();
    }

    public function save($path)
    {
        $writer = new Xls($this->spreedsheet);
        $writer->save($path);
    }

    /**
     * @throws XlsPatternGeneratorException
     */
    protected function processSheets(): bool
    {
        /**
         * @var $sheet SpreadSheetConfig
         */
        foreach ($this->json['sheets'] as $key => &$sheet) {
            $myWorkSheet = new Worksheet($this->spreedsheet);
            try {
                $this->currentSheet = $this->spreedsheet->addSheet($myWorkSheet, $key);
            } catch (Exception $e) {
                throw new XlsPatternGeneratorException($e->getMessage(), $e->getCode(), $e);
            }

            $this->configCurrentSheet($sheet)
                ->processWorkSheet();
        }

        return true;
    }

    /**
     * @param $sheet
     * @return XlsPatternGenerator
     * @throws XlsPatternGeneratorException
     */
    protected function configCurrentSheet(&$sheet): self
    {
        $this->currentWorksheetConfig = new SpreadsheetProcessor($sheet);
        return $this;
    }

    protected function processWorkSheet(): bool
    {
        $this->currentWorksheetConfig->setWorksheet($this->currentSheet)
            ->setFirstLine();
        if ($this->withHeader === true) {
            $this->currentWorksheetConfig->setHeader();
        }
        return $this->currentWorksheetConfig->process();
    }
}
