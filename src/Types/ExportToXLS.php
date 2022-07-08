<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Types;

use Tall\Report\Common\Entity\Row;
use Tall\Report\Common\Entity\Style\{Color, Style};
use Tall\Report\Common\Exception\IOException;
use Tall\Report\Writer\Exception\WriterNotOpenedException;
use Tall\Report\Writer\XLSX\{Options, Writer};
use Tall\Report\Exportable;
use Tall\Report\Contracts\ExportInterface;
use Tall\Report\{Export};
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportToXLS extends Export implements ExportInterface
{
    /**
     * @throws \Exception
     */
    public function download(Exportable|array $exportOptions): BinaryFileResponse
    {
        $deleteFileAfterSend = boolval(data_get($exportOptions, 'deleteFileAfterSend', true));
        $this->striped       = strval(data_get($exportOptions, 'striped', false));

        /** @var array $columnWidth */
        $columnWidth         = data_get($exportOptions, 'columnWidth', []);
        $this->columnWidth   = $columnWidth;

        $this->build();

        return response()
            ->download(storage_path($this->fileName . '.xlsx'))
            ->deleteFileAfterSend($deleteFileAfterSend);
    }

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     */
    public function build(): void
    {
        $data = $this->prepare($this->data, $this->columns);
     
        $options = new Options();
        $writer  = new Writer($options);

        $writer->openToFile(storage_path($this->fileName . '.xlsx'));

        $style = (new Style())
            ->setFontBold()
            ->setFontName('Arial')
            ->setFontSize(12)
            ->setFontColor(Color::BLACK)
            ->setShouldWrapText(false);
            //->setBackgroundColor('d0d3d8');

        $row = Row::fromValues(data_get($data, 'headers'), $style);

        $writer->addRow($row);

        /**
         * @var int<1, max> $column
         * @var float $width
         */
        foreach ($this->columns as $column) {
            if($width = data_get($column, 'attribute.width')){
                $options->setColumnWidth($width, $column);
            }
        }

        $default = (new Style())
            ->setFontName('Arial')
            ->setFontSize(12);

        $gray = (new Style())
            ->setFontName('Arial')
            ->setFontSize(12)
            ->setBackgroundColor(Color::WHITE);

        /** @var array<string> $row */
        foreach (data_get($data,'rows') as $key => $row) {
            if (count($row)) {
                if ( $row=array_filter($row)) {
                    if ($key % 2 && $this->striped) {
                        $row = Row::fromValues($row, $gray);
                    } else {
                        $row = Row::fromValues($row, $default);
                    }
                    $writer->addRow($row);
                }
            }
        }

        $writer->close();
    }
}