<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Common\Entity\Cell;

use DateTimeInterface;
use Tall\Report\Common\Entity\Cell;
use Tall\Report\Common\Entity\Style\Style;

final class DateTimeCell extends Cell
{
    private DateTimeInterface $value;

    public function __construct(DateTimeInterface $value, ?Style $style)
    {
        $this->value = $value;
        parent::__construct($style);
    }

    public function getValue(): DateTimeInterface
    {
        return $this->value;
    }
}
