<?php

namespace IshyEvandro\XlsPatternGenerator;

use IshyEvandro\XlsPatternGenerator\Processors\WorksheetConfig;
use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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
     * @var WorksheetConfig
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
    public function proccess(): bool
    {
        $this->spreedSheetConfig();
        $this->proccessSheets();
        return true;
    }

    /**
     * @return XlsPatternGenerator
     */
    protected function spreedSheetConfig(): self
    {
        return $this;
    }

    /**
     * @throws XlsPatternGeneratorException
     */
    protected function proccessSheets(): bool
    {
        foreach ($this->json["sheets"] as $key => $sheet) {
            $myWorkSheet = new Worksheet($this->spreedsheet, 'My Data');
            try {
                $this->currentSheet = $this->spreedsheet->addSheet($myWorkSheet, $key);
            } catch (\Exception $e) {
                throw new XlsPatternGeneratorException($e->getMessage(), $e->getCode(), $e);
            }
            $this->configCurrentSheet($sheet);
        }

        return true;
    }

    /**
     * @param $sheet
     * @return XlsPatternGenerator
     */
    protected function configCurrentSheet(&$sheet): self
    {
        $this->currentWorksheetConfig = new WorksheetConfig($sheet["config"]);
        return $this;
    }
}
