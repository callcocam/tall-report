<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader;

/**
 * @template T of SheetIteratorInterface
 */
interface ReaderInterface
{
    /**
     * Prepares the reader to read the given file. It also makes sure
     * that the file exists and is readable.
     *
     * @param string $filePath Path of the file to be read
     *
     * @throws \Tall\Report\Common\Exception\IOException
     */
    public function open(string $filePath): void;

    /**
     * Returns an iterator to iterate over sheets.
     *
     * @throws \Tall\Report\Reader\Exception\ReaderNotOpenedException If called before opening the reader
     *
     * @return T
     */
    public function getSheetIterator(): SheetIteratorInterface;

    /**
     * Closes the reader, preventing any additional reading.
     */
    public function close(): void;
}
