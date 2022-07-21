<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\Exception\Border;

use Tall\Report\Common\Entity\Style\BorderPart;
use Tall\Report\Writer\Exception\WriterException;

final class InvalidStyleException extends WriterException
{
    public function __construct(string $name)
    {
        $msg = '%s is not a valid style identifier for a border. Valid identifiers are: %s.';

        parent::__construct(sprintf($msg, $name, implode(',', BorderPart::allowedStyles)));
    }
}
