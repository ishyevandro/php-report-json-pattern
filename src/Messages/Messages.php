<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Messages;

use IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException;

class Messages
{
    const CONFIG_MISS_FIELD = 'ce';
    const MESSAGES = [
        self::CONFIG_MISS_FIELD => 'Missing config. {ce}'
    ];

    /**
     * @param string $const
     * @param array $values
     * @return string
     * @throws XlsPatternGeneratorException
     */
    public static function getMessage(string $const, $values = []): string
    {
        if (!array_key_exists($const, self::MESSAGES)) {
            throw new XlsPatternGeneratorException("Message {$const} not found.");
        }

        $response = self::MESSAGES[$const];
        foreach ($values as $key => $value) {
            $response = str_replace($key, $value, $response);
        }

        return $response;
    }
}
