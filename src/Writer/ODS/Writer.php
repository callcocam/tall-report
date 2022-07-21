<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\ODS;

use Tall\Report\Common\Helper\Escaper\ODS;
use Tall\Report\Writer\AbstractWriterMultiSheets;
use Tall\Report\Writer\Common\Entity\Workbook;
use Tall\Report\Writer\Common\Helper\ZipHelper;
use Tall\Report\Writer\Common\Manager\Style\StyleMerger;
use Tall\Report\Writer\ODS\Helper\FileSystemHelper;
use Tall\Report\Writer\ODS\Manager\Style\StyleManager;
use Tall\Report\Writer\ODS\Manager\Style\StyleRegistry;
use Tall\Report\Writer\ODS\Manager\WorkbookManager;
use Tall\Report\Writer\ODS\Manager\WorksheetManager;

final class Writer extends AbstractWriterMultiSheets
{
    /** @var string Content-Type value for the header */
    protected static string $headerContentType = 'application/vnd.oasis.opendocument.spreadsheet';
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

        $fileSystemHelper = new FileSystemHelper($this->options->getTempFolder(), new ZipHelper());
        $fileSystemHelper->createBaseFilesAndFolders();

        $styleMerger = new StyleMerger();
        $styleManager = new StyleManager(new StyleRegistry($this->options->DEFAULT_ROW_STYLE), $this->options);
        $worksheetManager = new WorksheetManager($styleManager, $styleMerger, new ODS());

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
