<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader\XLSX;

use Tall\Report\Common\Exception\IOException;
use Tall\Report\Common\Helper\Escaper\XLSX;
use Tall\Report\Reader\AbstractReader;
use Tall\Report\Reader\XLSX\Manager\SharedStringsCaching\CachingStrategyFactory;
use Tall\Report\Reader\XLSX\Manager\SharedStringsCaching\MemoryLimit;
use Tall\Report\Reader\XLSX\Manager\SharedStringsManager;
use Tall\Report\Reader\XLSX\Manager\SheetManager;
use Tall\Report\Reader\XLSX\Manager\WorkbookRelationshipsManager;
use ZipArchive;

/**
 * @extends AbstractReader<SheetIterator>
 */
final class Reader extends AbstractReader
{
    private ZipArchive $zip;

    /** @var SharedStringsManager Manages shared strings */
    private SharedStringsManager $sharedStringsManager;

    /** @var SheetIterator To iterator over the XLSX sheets */
    private SheetIterator $sheetIterator;

    private Options $options;
    private CachingStrategyFactory $cachingStrategyFactory;

    public function __construct(
        ?Options $options = null,
        ?CachingStrategyFactory $cachingStrategyFactory = null
    ) {
        $this->options = $options ?? new Options();

        if (null === $cachingStrategyFactory) {
            $memoryLimit = \ini_get('memory_limit');
            \assert(false !== $memoryLimit);

            $cachingStrategyFactory = new CachingStrategyFactory(new MemoryLimit($memoryLimit));
        }
        $this->cachingStrategyFactory = $cachingStrategyFactory;
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
     * It also parses the sharedStrings.xml file to get all the shared strings available in memory
     * and fetches all the available sheets.
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

        $this->sharedStringsManager = new SharedStringsManager(
            $filePath,
            $this->options,
            new WorkbookRelationshipsManager($filePath),
            $this->cachingStrategyFactory
        );

        if ($this->sharedStringsManager->hasSharedStrings()) {
            // Extracts all the strings from the sheets for easy access in the future
            $this->sharedStringsManager->extractSharedStrings();
        }

        $this->sheetIterator = new SheetIterator(
            new SheetManager(
                $filePath,
                $this->options,
                $this->sharedStringsManager,
                new XLSX()
            )
        );
    }

    /**
     * Closes the reader. To be used after reading the file.
     */
    protected function closeReader(): void
    {
        $this->zip->close();
        $this->sharedStringsManager->cleanup();
    }
}
