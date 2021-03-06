<?php

namespace App\Exports;

use App\Voter;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class CrossoversExport implements FromCollection, Responsable, WithMapping, WithHeadings, WithColumnFormatting, WithEvents, ShouldAutoSize
{
    use Exportable;
    
    /**
     * @var int
     */
    protected $totalRows;
    
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'crossovers.xlsx';
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $voter = Voter::where('total_votes', '>=', 2)
            ->where(function ($query) {
                $query->whereIn('e_1', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->whereNotNull('e_1');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_3', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_3');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_4', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_4');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_6', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_6');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_7', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_7');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_9', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_9');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_11', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_11');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_13', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_13');
            })
            ->where(function ($query) {
                $query->whereNotIn('e_15', ['YRY', 'NRY', 'YRN', 'NRN'])
                    ->orWhereNull('e_15');
            })
            ->orderBy('pct', 'asc')
            ->orderBy('street_address', 'asc')
            ->orderBy('house_number', 'asc');
        
        $this->totalRows = $voter->count() + 1;
        
        return $voter->get();
    }
    
    /**
     * @param mixed $voter
     * @return array
     */
    public function map($voter): array
    {
        return [
            $voter->first_name,
            $voter->last_name,
            $voter->address,
            $voter->pct_nbr,
            $voter->total_votes,
            $voter->republican_votes,
            $voter->democrat_votes,
            getVoteCode($voter->e_1),
            getVoteCode($voter->e_3),
            getVoteCode($voter->e_4),
            getVoteCode($voter->e_6),
            getVoteCode($voter->e_7),
            getVoteCode($voter->e_9),
            getVoteCode($voter->e_11),
            getVoteCode($voter->e_13),
            getVoteCode($voter->e_15),
        ];
    }
    
    /**
     * @return array
     */
    public function headings() : array
    {
        return [
            'FNAME',
            'LNAME',
            'ADDRESS',
            'PCT',
            'T',
            'R',
            'D',
            getElectionDate('e_1'),
            getElectionDate('e_3'),
            getElectionDate('e_4'),
            getElectionDate('e_6'),
            getElectionDate('e_7'),
            getElectionDate('e_9'),
            getElectionDate('e_11'),
            getElectionDate('e_13'),
            getElectionDate('e_15'),
        ];
    }
    
    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->getProperties()
                    ->setCreator("Daniel Berry")
                    ->setCompany('Coffee County GOP')
                    ->setManager('Daniel Berry')
                    ->setLastModifiedBy("Daniel Berry")
                    ->setTitle("Walk List")
                    ->setSubject("2018 Cross Over List")
                    ->setDescription(
                        "This is a list of voters who prior to the 5/18 elections had only voted democrat, but voted republican in 5/18. The list does not include new voters."
                    )
                    ->setKeywords("coffee county walk list 2018")
                    ->setCategory("Campaign Material");
            },
        
            AfterSheet::class => function (AfterSheet $event) {
            
                $event->sheet->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setMargins('0.25', '0.25', '0.25', '0.25');
                $event->sheet->setRepeatRows(1, 1);
                $event->sheet->getPageSetup()->setFitToWidth(1);
                $event->sheet->getPageSetup()->setFitToHeight(0);
                $event->sheet->freezePane("A2");
                $event->sheet->setAllBorders("A1:P{$this->totalRows}");
                $event->sheet->setFirstRowBorders("A1:P1");
                $event->sheet->alignHorizontalCenter("E1:P" . $this->totalRows);
                $event->sheet->alignHorizontalCenter("D1:D" . $this->totalRows);
            },
        ];
    }
}
