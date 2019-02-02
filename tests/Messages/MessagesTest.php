<?php
declare(strict_types=1);

use IshyEvandro\XlsPatternGenerator\Messages\Messages;
use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    public function testMessageNotFound(): void
    {
        $this->expectException(XlsPatternGeneratorException::class);
        $findMessage = 'TEST_NOT_FOUND';
        $this->expectExceptionMessage("Message {$findMessage} not found");
        Messages::getMessage($findMessage);
    }

    public function testGetMessageWithoutParameter(): void
    {
        $this->assertEquals(
            Messages::MESSAGES[Messages::CONFIG_MISSING_FIELD],
            Messages::getMessage(Messages::CONFIG_MISSING_FIELD)
        );
    }

    public function testGetMessageWithParameter(): void
    {
        $field = 'test';
        $expected = str_replace('{field}', $field, Messages::MESSAGES[Messages::CONFIG_MISSING_FIELD]);
        $this->assertEquals(
            $expected,
            Messages::getMessage(Messages::CONFIG_MISSING_FIELD, [
                '{field}' => $field
            ])
        );
    }
}
