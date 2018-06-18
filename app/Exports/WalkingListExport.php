<?php

namespace App\Exports;

use App\Voter;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class WalkingListExport implements FromCollection, Responsable, WithMapping, WithHeadings, WithEvents, ShouldAutoSize
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
    private $fileName = 'walking_list.xlsx';
    
    public function collection()
    {
        $voters = Voter::where('pct_nbr', 20)
            ->where('total_votes', '>', 0)
            ->orderBy('street_address', 'asc')
            ->orderBy('house_number', 'asc')
            ->orderBy('last_name', 'asc');
        
        $this->totalRows = $voters->count() + 1;
        
        return $voters->get();
    }
    
    public function map($voter): array
    {
        return [
            $voter->first_name,
            $voter->last_name,
            $voter->address,
            $voter->pct_nbr,
            $voter->total_votes,
            round(($voter->republican_votes/$voter->total_votes) * 100 . '%'),
            $voter->republican_votes,
            $voter->democrat_votes,
            $this->formatVotingCode($voter->e_1),
            $this->formatVotingCode($voter->e_3),
            $this->formatVotingCode($voter->e_4),
            $this->formatVotingCode($voter->e_6),
            $this->formatVotingCode($voter->e_7),
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
            '%',
            'R',
            'D',
            '5/18',
            '8/16',
            '3/16',
            '8/14',
            '5/14',
        ];
    }
    
    protected function formatVotingCode($code)
    {
        $codeMap = [
            'YRY' => 'ER',
            'NRY' => 'R',
            'YRN' => 'R',
            'NRN' => 'R',
            'YDY' => 'ED',
            'NDY' => 'D',
            'YDN' => 'ED',
            'NDN' => 'D',
            'YY' => 'E',
            'NY' => 'Y',
            'YN' => 'Y',
            'NN' => 'Y',
        ];
        
        if ( ! empty($code)) {
            return array_get($codeMap, $code, '?');
        }
        
        return '';
    }
    
    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->getProperties()
                    ->setCreator("Daniel Berry")
                    ->setCompany('Coffee County GOP')
                    ->setManager('Daniel Berry')
                    ->setLastModifiedBy("Daniel Berry")
                    ->setTitle("Walk List")
                    ->setSubject("2018 Voter Walk List")
                    ->setDescription(
                        "Walk list with data provided by the Coffee County Election Commission. Data includes all elections from 2/2008 through 5/2018."
                    )
                    ->setKeywords("coffee county walk list 2018")
                    ->setCategory("Campaign Material");
            },
            
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->setMargins('0.25', '0.25', '0.25', '0.25');
                $event->sheet->setRepeatRows(1, 1);
    
                $event->sheet->getPageSetup()->setFitToWidth(1);
                $event->sheet->getPageSetup()->setFitToHeight(0);
    
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $range = "A1:M{$this->totalRows}";
    
                $event->sheet->getStyle($range)->applyFromArray($styleArray);
    
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
    
                $range = "A1:M1";
    
                $event->sheet->getStyle($range)->applyFromArray($styleArray);
                
                $range = "E1:M" . $this->totalRows;
                
                $event->sheet->getStyle($range)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
                $range = "D1:D" . $this->totalRows;
    
                $event->sheet->getStyle($range)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->freezePane("A2");
                
                
            },
        ];
    }
    
}
