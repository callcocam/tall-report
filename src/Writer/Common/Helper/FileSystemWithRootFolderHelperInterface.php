<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Writer\Common\Helper;

use Tall\Report\Common\Helper\FileSystemHelperInterface;

/**
 * @internal
 */
interface FileSystemWithRootFolderHelperInterface extends FileSystemHelperInterface
{
    /**
     * Creates all the folders needed to create a spreadsheet, as well as the files that won't change.
     *
     * @throws \Tall\Report\Common\Exception\IOException If unable to create at least one of the base folders
     */
    public function createBaseFilesAndFolders(): void;

    public function getRootFolder(): string;

    public function getSheetsContentTempFolder(): string;
}
