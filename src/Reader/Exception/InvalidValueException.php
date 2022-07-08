<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader\Exception;

use Throwable;

final class InvalidValueException extends ReaderException
{
    private string $invalidValue;

    public function __construct(string $invalidValue, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->invalidValue = $invalidValue;
        parent::__construct($message, $code, $previous);
    }

    public function getInvalidValue(): string
    {
        return $this->invalidValue;
    }
}
