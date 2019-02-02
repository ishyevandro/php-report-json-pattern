<?php

use IshyEvandro\XlsPatternGenerator\Messages\Messages;
use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;
use PHPUnit\Framework\TestCase;

class WorksheetConfigTest extends TestCase
{
    public function testMessageNotFound()
    {
        $this->expectException(XlsPatternGeneratorException::class);
        $findMessage = "TEST_NOT_FOUND";
        $this->expectExceptionMessage("Message {$findMessage} not found");
        Messages::getMessage($findMessage);
    }

    public function testGetMessageWithoutParameter()
    {
        $this->assertEquals(Messages::MESSAGES[Messages::CONFIG_MISS_FIELD], Messages::getMessage(Messages::CONFIG_MISS_FIELD));
    }
}