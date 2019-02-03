<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Interfaces;

interface IErrorMessage
{
    public function setErrorMessage(string $errorMessage): void;

    public function getErrorMessage(): string;
}
