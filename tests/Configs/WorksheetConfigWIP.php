<?php

use IshyEvandro\XlsPatternGenerator\Processors\SpreadsheetProcessor;
use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use PHPUnit\Framework\TestCase;

class WorksheetConfigWIP extends TestCase
{
    public function testConstructWithCorrectJsonShouldNotThrowException()
    {
        new SpreadsheetProcessor($this->config());
        $this->assertTrue(true);
    }

    public function testConstructWithJsonWithoutFieldsShouldThrownException()
    {
        $this->expectException(XlsPatternGeneratorException::class);
        $json = $this->config();
        unset($json['fields']);
        new SpreadsheetProcessor($json);
    }

    public function testConstructWithJsonWithoutFirstColumnShouldThrownException()
    {
        $this->expectException(XlsPatternGeneratorException::class);
        $json = $this->config();
        unset($json['first_column']);
        new SpreadsheetProcessor($json);
    }

    public function testConstructWithJsonWithoutHeaderLineShouldThrownException()
    {
        $this->expectException(XlsPatternGeneratorException::class);
        $json = $this->config();
        unset($json['header_line']);
        new SpreadsheetProcessor($json);
    }

    protected function config()
    {
        return json_decode(
            '{
                "fields": [
                  "field_1",
                  "field_2",
                  "field_3",
                  "field_4"
                ],
                "first_column": "A",
                "header_line": 1
              }',
            true
        );
    }
}