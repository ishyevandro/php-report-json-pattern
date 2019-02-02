<?php

use IshyEvandro\XlsPatternGenerator\Config\SpreadSheetConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class SpreadSheetConfigTest
 */
class SpreadSheetConfigTest extends TestCase
{
    public function testValidateShouldReturnFalseWithMissingParameter(): void
    {
        $class = $this->getClass([]);
        $this->assertFalse($class->validate());
    }

    public function testValidateShouldReturnTrueWithCorrectParameters(): void
    {
        $class = $this->getClass([
            'fields' => [],
            'first_column' => 'A',
            'header_line_position' => 0
        ]);

        $this->assertTrue($class->validate());
    }

    protected function getClass($data): SpreadSheetConfig
    {
        return new SpreadSheetConfig($data);
    }
}
