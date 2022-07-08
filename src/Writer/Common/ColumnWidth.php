<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\Common;

/**
 * @internal
 */
final class ColumnWidth
{
    /**
     * @param positive-int $start
     * @param positive-int $end
     */
    public function __construct(
        public int $start,
        public int $end,
        public float $width,
    ) {
    }
}
