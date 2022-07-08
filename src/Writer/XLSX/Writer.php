<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\XLSX;

use Tall\Report\Common\Helper\Escaper\XLSX;
use Tall\Report\Common\Helper\StringHelper;
use Tall\Report\Writer\AbstractWriterMultiSheets;
use Tall\Report\Writer\Common\Entity\Workbook;
use Tall\Report\Writer\Common\Helper\ZipHelper;
use Tall\Report\Writer\Common\Manager\Style\StyleMerger;
use Tall\Report\Writer\XLSX\Helper\FileSystemHelper;
use Tall\Report\Writer\XLSX\Manager\SharedStringsManager;
use Tall\Report\Writer\XLSX\Manager\Style\StyleManager;
use Tall\Report\Writer\XLSX\Manager\Style\StyleRegistry;
use Tall\Report\Writer\XLSX\Manager\WorkbookManager;
use Tall\Report\Writer\XLSX\Manager\WorksheetManager;

final class Writer extends AbstractWriterMultiSheets
{
    /** @var string Content-Type value for the header */
    protected static string $headerContentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    private Options $options;

    public function __construct(?Options $options = null)
    {
        $this->options = $options ?? new Options();
    }

    public function getOptions(): Options
    {
        return $this->options;
    }

    protected function createWorkbookManager(): WorkbookManager
    {
        $workbook = new Workbook();

        $fileSystemHelper = new FileSystemHelper(
            $this->options->getTempFolder(),
            new ZipHelper(),
            new XLSX()
        );
        $fileSystemHelper->createBaseFilesAndFolders();

        $xlFolder = $fileSystemHelper->getXlFolder();
        $sharedStringsManager = new SharedStringsManager($xlFolder, new XLSX());

        $styleMerger = new StyleMerger();
        $styleManager = new StyleManager(new StyleRegistry($this->options->DEFAULT_ROW_STYLE));

        $worksheetManager = new WorksheetManager(
            $this->options,
            $styleManager,
            $styleMerger,
            $sharedStringsManager,
            new XLSX(),
            StringHelper::factory()
        );

        return new WorkbookManager(
            $workbook,
            $this->options,
            $worksheetManager,
            $styleManager,
            $styleMerger,
            $fileSystemHelper
        );
    }
}
