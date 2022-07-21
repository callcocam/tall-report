<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\XLSX;

/**
 * @internal
 */
final class MergeCell
{
    /**
     * @param 0|positive-int $sheetIndex
     * @param 0|positive-int $topLeftColumn
     * @param positive-int   $topLeftRow
     * @param 0|positive-int $bottomRightColumn
     * @param positive-int   $bottomRightRow
     */
    public function __construct(
        public int $sheetIndex,
        public int $topLeftColumn,
        public int $topLeftRow,
        public int $bottomRightColumn,
        public int $bottomRightRow,
    ) {
    }
}
