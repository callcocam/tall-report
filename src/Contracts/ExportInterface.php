<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Contracts;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface ExportInterface
{
    public function download(array $exportOptions): BinaryFileResponse;

    public function build(): void;
}