<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer;

use Tall\Report\Common\Entity\Row;
use Tall\Report\Common\Exception\IOException;
use Tall\Report\Writer\Common\Entity\Sheet;
use Tall\Report\Writer\Common\Manager\WorkbookManagerInterface;
use Tall\Report\Writer\Exception\SheetNotFoundException;
use Tall\Report\Writer\Exception\WriterNotOpenedException;

abstract class AbstractWriterMultiSheets extends AbstractWriter
{
    private WorkbookManagerInterface $workbookManager;

    /**
     * Returns all the workbook's sheets.
     *
     * @throws WriterNotOpenedException If the writer has not been opened yet
     *
     * @return Sheet[] All the workbook's sheets
     */
    final public function getSheets(): array
    {
        $this->throwIfWorkbookIsNotAvailable();

        $externalSheets = [];
        $worksheets = $this->workbookManager->getWorksheets();

        foreach ($worksheets as $worksheet) {
            $externalSheets[] = $worksheet->getExternalSheet();
        }

        return $externalSheets;
    }

    /**
     * Creates a new sheet and make it the current sheet. The data will now be written to this sheet.
     *
     * @throws IOException
     * @throws WriterNotOpenedException If the writer has not been opened yet
     *
     * @return Sheet The created sheet
     */
    final public function addNewSheetAndMakeItCurrent(): Sheet
    {
        $this->throwIfWorkbookIsNotAvailable();
        $worksheet = $this->workbookManager->addNewSheetAndMakeItCurrent();

        return $worksheet->getExternalSheet();
    }

    /**
     * Returns the current sheet.
     *
     * @throws WriterNotOpenedException If the writer has not been opened yet
     *
     * @return Sheet The current sheet
     */
    final public function getCurrentSheet(): Sheet
    {
        $this->throwIfWorkbookIsNotAvailable();

        return $this->workbookManager->getCurrentWorksheet()->getExternalSheet();
    }

    /**
     * Sets the given sheet as the current one. New data will be written to this sheet.
     * The writing will resume where it stopped (i.e. data won't be truncated).
     *
     * @param Sheet $sheet The sheet to set as current
     *
     * @throws SheetNotFoundException   If the given sheet does not exist in the workbook
     * @throws WriterNotOpenedException If the writer has not been opened yet
     */
    final public function setCurrentSheet(Sheet $sheet): void
    {
        $this->throwIfWorkbookIsNotAvailable();
        $this->workbookManager->setCurrentSheet($sheet);
    }

    abstract protected function createWorkbookManager(): WorkbookManagerInterface;

    /**
     * {@inheritdoc}
     */
    protected function openWriter(): void
    {
        if (!isset($this->workbookManager)) {
            $this->workbookManager = $this->createWorkbookManager();
            $this->workbookManager->addNewSheetAndMakeItCurrent();
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception\WriterException
     */
    protected function addRowToWriter(Row $row): void
    {
        $this->throwIfWorkbookIsNotAvailable();
        $this->workbookManager->addRowToCurrentWorksheet($row);
    }

    /**
     * {@inheritdoc}
     */
    protected function closeWriter(): void
    {
        if (isset($this->workbookManager)) {
            $this->workbookManager->close($this->filePointer);
        }
    }

    /**
     * Checks if the workbook has been created. Throws an exception if not created yet.
     *
     * @throws WriterNotOpenedException If the workbook is not created yet
     */
    private function throwIfWorkbookIsNotAvailable(): void
    {
        if (!isset($this->workbookManager)) {
            throw new WriterNotOpenedException('The writer must be opened before performing this action.');
        }
    }
}
