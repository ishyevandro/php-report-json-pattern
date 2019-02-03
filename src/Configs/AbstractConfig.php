<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

use IshyEvandro\XlsPatternGenerator\Interfaces\IConfigValidate;
use IshyEvandro\XlsPatternGenerator\Messages\Messages;

abstract class AbstractConfig implements IConfigValidate
{
    /**
     * @var array
     */
    protected $config = [];
    /**
     * @var array
     */
    protected $expectedConfig = [];

    /**
     * @var string
     */
    protected $errorMessage = '';

    protected $jsonPathPrefix = '';
    /**
     * spreadSheetConfig constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->config = $data;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->errorMessage;
    }


    /**
     * @return bool
     * @throws \IshyEvandro\XlsPatternGenerator\Exceptions\XlsPatternGeneratorException
     */
    protected function checkKeys(): bool
    {
        foreach ($this->expectedConfig as $config => $parameters) {
            if (!\array_key_exists($config, $this->config)) {
                $this->errorMessage = Messages::getMessage(Messages::CONFIG_MISSING_FIELD, [
                    '{field}' => $this->jsonPathPrefix . $config
                ]);
                return false;
            }
        }

        return true;
    }
}
