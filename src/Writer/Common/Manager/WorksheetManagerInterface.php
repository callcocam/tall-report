<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\Common\Manager;

use Tall\Report\Common\Entity\Row;
use Tall\Report\Writer\Common\Entity\Worksheet;

/**
 * @internal
 */
interface WorksheetManagerInterface
{
    /**
     * Adds a row to the worksheet.
     *
     * @param Worksheet $worksheet The worksheet to add the row to
     * @param Row       $row       The row to be added
     *
     * @throws \Tall\Report\Common\Exception\IOException              If the data cannot be written
     * @throws \Tall\Report\Common\Exception\InvalidArgumentException If a cell value's type is not supported
     */
    public function addRow(Worksheet $worksheet, Row $row): void;

    /**
     * Prepares the worksheet to accept data.
     *
     * @param Worksheet $worksheet The worksheet to start
     *
     * @throws \Tall\Report\Common\Exception\IOException If the sheet data file cannot be opened for writing
     */
    public function startSheet(Worksheet $worksheet): void;

    /**
     * Closes the worksheet.
     */
    public function close(Worksheet $worksheet): void;
}
