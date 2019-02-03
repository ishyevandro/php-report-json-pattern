<?php
declare(strict_types=1);

namespace IshyEvandro\XlsPatternGenerator\Traits;

trait ErrorMessageTrait
{
    /**
     * @var string
     */
    protected $errorMessage = '';

    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
