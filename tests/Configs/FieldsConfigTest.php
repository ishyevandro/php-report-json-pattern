<?php

use IshyEvandro\XlsPatternGenerator\Configs\FieldConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class SpreadSheetConfigTest
 */
class FieldConfigTest extends TestCase
{
    public function testValidateShouldReturnFalseWithMissingParameter(): void
    {
        $class = $this->getClass([]);
        $this->assertFalse($class->validate());
    }

    public function testValidateShouldReturnTrueWithCorrectParameters(): void
    {
        $class = $this->getClass([
            'name' => '',
            'position' => 'A',
            'type' => 0,
            'json_row_key' => 'a'
        ]);

        $this->assertTrue($class->validate());
    }

    protected function getClass($data): FieldConfig
    {
        return new FieldConfig($data);
    }
}
