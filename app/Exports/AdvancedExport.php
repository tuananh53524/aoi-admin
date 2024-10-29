<?php

namespace App\Exports;

use App\Traits\ExcelConfigurable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\Builder;

abstract class AdvancedExport extends DefaultValueBinder implements 
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithColumnFormatting,
    WithCustomValueBinder,
    WithEvents
{
    use ExcelConfigurable;

    protected Builder $query;
    protected array $headingStyle = [];
    protected array $rowStyle = [];

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    public function columnFormats(): array
    {
        return $this->columnFormats;
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1 => array_merge([
                'font' => ['bold' => true],
                'background' => ['color' => ['rgb' => 'E2E8F0']],
            ], $this->headingStyle),
        ];

        if (!empty($this->rowStyle)) {
            $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
                ->applyFromArray($this->rowStyle);
        }

        return $styles;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                if (!$this->shouldAutoSize && !empty($this->columnWidths)) {
                    foreach ($this->columnWidths as $column => $width) {
                        $event->sheet->getColumnDimension($column)->setWidth($width);
                    }
                }

                if (isset($this->callbacks[AfterSheet::class])) {
                    call_user_func($this->callbacks[AfterSheet::class], $event);
                }
            },
        ];
    }
}