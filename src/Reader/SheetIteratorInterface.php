<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader;

use Iterator;

/**
 * @template T of SheetInterface
 * @extends Iterator<T>
 */
interface SheetIteratorInterface extends Iterator
{
    /**
     * @return T of SheetInterface
     */
    public function current(): SheetInterface;
}
