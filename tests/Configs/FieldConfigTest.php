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
        $class = $this->getClass($this->getPayload());

        $this->assertTrue($class->validate());
    }

    public function testGetRowKey(): void
    {
        $class = $this->getClass($this->getPayload());

        $this->assertEquals('name', $class->getRowKey());
    }

    public function testGetPosition(): void
    {
        $class = $this->getClass($this->getPayload());

        $this->assertEquals('A', $class->getPosition());
    }

    protected function getClass($data): FieldConfig
    {
        return new FieldConfig($data);
    }

    /**
     * @return array
     */
    protected function getPayload(): array
    {
        return [
            'name' => '',
            'position' => 'A',
            'type' => 0,
            'json_row_key' => 'name'
        ];
    }
}
