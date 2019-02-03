<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Traits;

use IshyEvandro\XlsPatternGenerator\Messages\Messages;

trait CheckKeysTrait
{
    /**
     * @param $expectedConfig
     * @param $passedConfig
     * @param string $jsonPathPrefix
     * @return bool
     * @throws \IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException
     */
    public function checkKeys(array &$expectedConfig, array &$passedConfig, string &$jsonPathPrefix): bool
    {
        foreach ($expectedConfig as $config => $parameters) {
            if (!\array_key_exists($config, $passedConfig)) {
                $this->errorMessage = Messages::getMessage(Messages::CONFIG_MISSING_FIELD, [
                    '{field}' => $jsonPathPrefix . $config
                ]);
                return false;
            }
        }

        return true;
    }
}
