<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Common\Entity\Cell;

use DateInterval;
use Tall\Report\Common\Entity\Cell;
use Tall\Report\Common\Entity\Style\Style;

final class DateIntervalCell extends Cell
{
    private DateInterval $value;

    public function __construct(DateInterval $value, ?Style $style)
    {
        $this->value = $value;
        parent::__construct($style);
    }

    public function getValue(): DateInterval
    {
        return $this->value;
    }
}
