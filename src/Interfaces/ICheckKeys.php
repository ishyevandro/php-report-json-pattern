<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Interfaces;

interface ICheckKeys
{
    public function checkKeys(array &$expectedConfig, array &$passedConfig, string &$jsonPathPrefix): bool;
}
