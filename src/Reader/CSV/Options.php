<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
declare(strict_types=1);

namespace Tall\Report\Reader\CSV;

use Tall\Report\Common\Helper\EncodingHelper;

final class Options
{
    public bool $SHOULD_PRESERVE_EMPTY_ROWS = false;
    public string $FIELD_DELIMITER = ',';
    public string $FIELD_ENCLOSURE = '"';
    public string $ENCODING = EncodingHelper::ENCODING_UTF8;
}
