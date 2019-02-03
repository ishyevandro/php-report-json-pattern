<?php

use IshyEvandro\XlsPatternGenerator\Configs\FieldConfig;
use IshyEvandro\XlsPatternGenerator\Messages\Messages;
use PHPUnit\Framework\TestCase;

/**
 * Class SpreadSheetConfigTest
 */
class FieldConfigTest extends TestCase
{
    public function testValidateShouldReturnFalseWithMissingParameter(): void
    {
        $payload = $this->getPayload();
        unset($payload['type']);
        $class = $this->getClass($payload);
        $this->assertFalse($class->validate());
        $this->assertEquals(Messages::getMessage(Messages::CONFIG_MISSING_FIELD, [
            '{field}' => 'sheets.*.config.fields.*.type'
        ]), $class->getErrorMessage());
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

    public function testGetColumn(): void
    {
        $class = $this->getClass($this->getPayload());

        $this->assertEquals('A', $class->getColumn());
    }

    public function testValidateShouldReturnFalseWhenTypeIsWrong(): void
    {
        $payload = $this->getPayload();
        $payload['type'] = 'test';
        $class = $this->getClass($payload);
        $this->assertFalse($class->validate());
        $this->assertEquals(
            Messages::getMessage(
                Messages::CONFIG_FIELD_TYPE_ERROR,
                [
                    '{wrong}' => 'test',
                    '{types}'  => FieldConfig::ACCEPTABLE_TYPES
                ]
            ),
            $class->getErrorMessage()
        );
    }

    public function testGetFieldName(): void
    {
        $class = $this->getClass($this->getPayload());
        $this->assertEquals('TestingName', $class->getFieldName());
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
            'name' => 'TestingName',
            'column' => 'A',
            'type' => 'string',
            'json_row_key' => 'name'
        ];
    }
}
