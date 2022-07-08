<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\Common\Creator;

use Tall\Report\Common\Exception\UnsupportedTypeException;
use Tall\Report\Writer\CSV\Writer as CSVWriter;
use Tall\Report\Writer\ODS\Writer as ODSWriter;
use Tall\Report\Writer\WriterInterface;
use Tall\Report\Writer\XLSX\Writer as XLSXWriter;

/**
 * This factory is used to create writers, based on the type of the file to be read.
 * It supports CSV, XLSX and ODS formats.
 */
final class WriterFactory
{
    /**
     * This creates an instance of the appropriate writer, given the extension of the file to be written.
     *
     * @param string $path The path to the spreadsheet file. Supported extensions are .csv,.ods and .xlsx
     *
     * @throws \Tall\Report\Common\Exception\UnsupportedTypeException
     */
    public static function createFromFile(string $path): WriterInterface
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($extension) {
            'csv' => new CSVWriter(),
            'xlsx' => new XLSXWriter(),
            'ods' => new ODSWriter(),
            default => throw new UnsupportedTypeException('No writers supporting the given type: '.$extension),
        };
    }
}
