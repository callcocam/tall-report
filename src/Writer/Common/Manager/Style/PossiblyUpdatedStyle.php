<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\Common\Manager\Style;

use Tall\Report\Common\Entity\Style\Style;

/**
 * @internal
 */
final class PossiblyUpdatedStyle
{
    private Style $style;
    private bool $isUpdated;

    public function __construct(Style $style, bool $isUpdated)
    {
        $this->style = $style;
        $this->isUpdated = $isUpdated;
    }

    public function getStyle(): Style
    {
        return $this->style;
    }

    public function isUpdated(): bool
    {
        return $this->isUpdated;
    }
}
