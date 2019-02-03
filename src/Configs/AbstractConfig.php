<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Configs;

use IshyEvandro\XlsPatternGenerator\Interfaces\{
    ICheckKeys,
    IConfigValidate,
    IErrorMessage
};
use IshyEvandro\XlsPatternGenerator\Traits\{
    CheckKeysTrait,
    ErrorMessageTrait
};

abstract class AbstractConfig implements IConfigValidate, IErrorMessage, ICheckKeys
{
    use ErrorMessageTrait, CheckKeysTrait;
    /**
     * @var array
     */
    protected $config = [];
    /**
     * @var array
     */
    protected $expectedConfig = [];

    protected $jsonPathPrefix = '';
    /**
     * spreadSheetConfig constructor.
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->config = $data;
    }
}
