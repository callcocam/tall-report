<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader;

/**
 * @template T of RowIteratorInterface
 *
 * @extends SheetInterface<T>
 */
interface SheetWithVisibilityInterface extends SheetInterface
{
    /**
     * @return bool Whether the sheet is visible
     */
    public function isVisible(): bool;
}
