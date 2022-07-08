<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader\ODS;

use Tall\Report\Common\Exception\IOException;
use Tall\Report\Common\Helper\Escaper\ODS;
use Tall\Report\Reader\AbstractReader;
use Tall\Report\Reader\ODS\Helper\SettingsHelper;
use ZipArchive;

/**
 * @extends AbstractReader<SheetIterator>
 */
final class Reader extends AbstractReader
{
    private ZipArchive $zip;

    private Options $options;

    /** @var SheetIterator To iterator over the ODS sheets */
    private SheetIterator $sheetIterator;

    public function __construct(?Options $options = null)
    {
        $this->options = $options ?? new Options();
    }

    public function getSheetIterator(): SheetIterator
    {
        $this->ensureStreamOpened();

        return $this->sheetIterator;
    }

    /**
     * Returns whether stream wrappers are supported.
     */
    protected function doesSupportStreamWrapper(): bool
    {
        return false;
    }

    /**
     * Opens the file at the given file path to make it ready to be read.
     *
     * @param string $filePath Path of the file to be read
     *
     * @throws \Tall\Report\Common\Exception\IOException            If the file at the given path or its content cannot be read
     * @throws \Tall\Report\Reader\Exception\NoSheetsFoundException If there are no sheets in the file
     */
    protected function openReader(string $filePath): void
    {
        $this->zip = new ZipArchive();

        if (true !== $this->zip->open($filePath)) {
            throw new IOException("Could not open {$filePath} for reading.");
        }

        $this->sheetIterator = new SheetIterator($filePath, $this->options, new ODS(), new SettingsHelper());
    }

    /**
     * Closes the reader. To be used after reading the file.
     */
    protected function closeReader(): void
    {
        $this->zip->close();
    }
}
