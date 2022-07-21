<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Common\Entity\Cell;

use Tall\Report\Common\Entity\Cell;
use Tall\Report\Common\Entity\Style\Style;

final class FormulaCell extends Cell
{
    private string $value;

    public function __construct(string $value, ?Style $style)
    {
        $this->value = $value;
        parent::__construct($style);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
