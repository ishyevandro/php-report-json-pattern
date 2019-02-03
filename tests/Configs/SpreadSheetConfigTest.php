<?php

use IshyEvandro\XlsPatternGenerator\Configs\SpreadSheetConfig;
use IshyEvandro\XlsPatternGenerator\Messages\Messages;
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
        $class = $this->getClass($this->getPayload());

        $this->assertTrue($class->validate());
    }

    public function testGetFieldsShouldReturnEmptyArrayWhenParameterFieldNotArray(): void
    {
        $payload = $this->getPayload();
        $payload['fields'] = 'wrong';
        $class = $this->getClass($payload);
        $this->assertTrue($class->validate());
        $this->assertCount(0, $class->getFields());
    }

    public function testGetFieldsShouldReturnOneElement(): void
    {
        $class = $this->getClass($this->getPayload());
        $this->assertTrue($class->validate());
        $this->assertCount(1, $class->getFields());
    }

    public function testValidateShouldReturnFalseWhenFieldIsNotValid(): void
    {
        $payload = $this->getPayload();
        unset($payload['fields'][0]['type']);
        $class = $this->getClass($payload);
        $this->assertFalse($class->validate());
        $this->assertEquals(Messages::getMessage(Messages::CONFIG_MISSING_FIELD, [
            '{field}' => 'sheets.*.config.fields.*.type'
        ]), $class->getErrorMessage());
    }

    protected function getClass($data): SpreadSheetConfig
    {
        return new SpreadSheetConfig($data);
    }

    protected function getPayload(): array
    {
        return [
            'fields' => [
                [
                    'name' => 'Test',
                    'column' => 'A',
                    'type' => 'string',
                    'json_row_key' => 'name'
                ]
            ],
            'header_line_position' => 0
        ];
    }
}
