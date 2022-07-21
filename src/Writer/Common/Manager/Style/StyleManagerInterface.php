<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\Common\Manager\Style;

use Tall\Report\Common\Entity\Cell;
use Tall\Report\Common\Entity\Style\Style;

/**
 * @internal
 */
interface StyleManagerInterface
{
    /**
     * Registers the given style as a used style.
     * Duplicate styles won't be registered more than once.
     *
     * @param Style $style The style to be registered
     *
     * @return Style the registered style, updated with an internal ID
     */
    public function registerStyle(Style $style): Style;

    /**
     * Apply additional styles if the given row needs it.
     * Typically, set "wrap text" if a cell contains a new line.
     *
     * @return PossiblyUpdatedStyle The eventually updated style
     */
    public function applyExtraStylesIfNeeded(Cell $cell): PossiblyUpdatedStyle;
}
