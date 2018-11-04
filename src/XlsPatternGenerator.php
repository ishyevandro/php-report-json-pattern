<?php

namespace IshyEvandro\XlsPatternGenerator;

use IshyEvandro\XlsPatternGenerator\Processors\WorksheetProcessor;
use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class XlsPatternGenerator
{
    /**
     * @var Spreadsheet
     */
    protected $spreedsheet;

    /**
     * @var Worksheet
     */
    protected $currentSheet;

    /**
     * @var WorksheetProcessor
     */
    protected $currentWorksheetConfig;

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
    public function process(): bool
    {
        $this->spreedSheetConfig();
        $this->processSheets();
        return true;
    }

    public function save($path)
    {
        $writer = new Xls($this->spreedsheet);
        $writer->save($path);
    }

    /**
     * Reserved
     *
     * @return XlsPatternGenerator
     */
    protected function spreedSheetConfig(): self
    {
        return $this;
    }

    /**
     * @throws XlsPatternGeneratorException
     */
    protected function processSheets(): bool
    {
        foreach ($this->json["sheets"] as $key => $sheet) {
            $myWorkSheet = new Worksheet($this->spreedsheet, $sheet['name']);
            try {
                $this->currentSheet = $this->spreedsheet->addSheet($myWorkSheet, $key);
            } catch (\Exception $e) {
                throw new XlsPatternGeneratorException($e->getMessage(), $e->getCode(), $e);
            }
            $this->configCurrentSheet($sheet)
                ->processWorkSheet($sheet);
        }

        return true;
    }

    /**
     * @param $sheet
     * @return XlsPatternGenerator
     */
    protected function configCurrentSheet(&$sheet): self
    {
        $this->currentWorksheetConfig = new WorksheetProcessor($sheet["config"]);
        return $this;
    }

    protected function processWorkSheet(&$sheet)
    {
        return $this->currentWorksheetConfig->process(
            $this->currentSheet,
            $sheet
        );
    }
}
