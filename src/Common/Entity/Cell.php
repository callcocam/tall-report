<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Common\Entity;

use DateInterval;
use DateTimeInterface;
use Tall\Report\Common\Entity\Cell\BooleanCell;
use Tall\Report\Common\Entity\Cell\DateIntervalCell;
use Tall\Report\Common\Entity\Cell\DateTimeCell;
use Tall\Report\Common\Entity\Cell\EmptyCell;
use Tall\Report\Common\Entity\Cell\FormulaCell;
use Tall\Report\Common\Entity\Cell\NumericCell;
use Tall\Report\Common\Entity\Cell\StringCell;
use Tall\Report\Common\Entity\Style\Style;

abstract class Cell
{
    private Style $style;

    public function __construct(?Style $style)
    {
        $this->setStyle($style);
    }

    abstract public function getValue(): null|bool|string|int|float|DateTimeInterface|DateInterval;

    final public function setStyle(?Style $style): void
    {
        $this->style = $style ?? new Style();
    }

    final public function getStyle(): Style
    {
        return $this->style;
    }

    final public static function fromValue(null|bool|string|int|float|DateTimeInterface|DateInterval $value, ?Style $style = null): self
    {
        if (\is_bool($value)) {
            return new BooleanCell($value, $style);
        }
        if (null === $value || '' === $value) {
            return new EmptyCell($value, $style);
        }
        if (\is_int($value) || \is_float($value)) {
            return new NumericCell($value, $style);
        }
        if ($value instanceof DateTimeInterface) {
            return new DateTimeCell($value, $style);
        }
        if ($value instanceof DateInterval) {
            return new DateIntervalCell($value, $style);
        }
        if (isset($value[0]) && '=' === $value[0]) {
            return new FormulaCell($value, $style);
        }

        return new StringCell($value, $style);
    }
}
