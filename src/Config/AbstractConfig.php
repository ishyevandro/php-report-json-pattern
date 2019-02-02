<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Config;

use IshyEvandro\XlsPatternGenerator\Interfaces\IConfigValidate;

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
}
