<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader;

use Iterator;
use Tall\Report\Common\Entity\Row;

/**
 * @extends Iterator<Row>
 */
interface RowIteratorInterface extends Iterator
{
    public function current(): ?Row;
}
