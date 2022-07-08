<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader\XLSX;

use Tall\Report\Common\TempFolderOptionTrait;

final class Options
{
    use TempFolderOptionTrait;

    public bool $SHOULD_FORMAT_DATES = false;
    public bool $SHOULD_PRESERVE_EMPTY_ROWS = false;
    public bool $SHOULD_USE_1904_DATES = false;
}
