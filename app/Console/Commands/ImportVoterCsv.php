<?php

namespace App\Console\Commands;

use App\Voter;
use Illuminate\Console\Command;
use League\Csv\Reader;

class ImportVoterCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voters:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the given voter csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        $reader = $this->readCsv();
    
        foreach ($reader as $index => $row) {
            if ($index > 0) {
                $this->fillVoterInformation($row);
            }
        }
        
        $this->info("Import complete");
        
        return true;
    }
    
    /**
     * Reads the CSV file.
     *
     * @return \League\Csv\Reader
     */
    protected function readCsv()
    {
        $file = storage_path("data/" . $this->argument('file'));
    
        return Reader::createFromPath($file, 'r');
    }
    
    /**
     * @param $row
     */
    protected function fillVoterInformation($row)
    {
        list($houseNumber, $streetAddress) = $this->parseAddress($row[4]);
        
        $data = [
            'state_id' => $row[0],
            'last_name' => $row[1],
            'first_name' => $row[2],
            'title' => $row[3],
            'house_number' => $houseNumber,
            'street_address' => $streetAddress,
            'address' => $row[4],
            'address2' => $row[5],
            'city' => $row[6],
            'state' => $row[7],
            'zip' => $row[8],
            'phone' => $this->parsePhoneNumber($row[9]),
            'pct_nbr' => $row[10],
            'mail' => $row[11],
            'mail_city' => $row[12],
            'mail_state' => $row[13],
            'mail_zip' => $row[14],
            'e_1' => $this->parseElectionYear($row[15]),
            'e_2' => $this->parseElectionYear($row[16]),
            'e_3' => $this->parseElectionYear($row[17]),
            'e_4' => $this->parseElectionYear($row[18]),
            'e_5' => $this->parseElectionYear($row[19]),
            'e_6' => $this->parseElectionYear($row[20]),
            'e_7' => $this->parseElectionYear($row[21]),
            'e_8' => $this->parseElectionYear($row[22]),
            'e_9' => $this->parseElectionYear($row[23]),
            'e_10' => $this->parseElectionYear($row[24]),
            'e_11' => $this->parseElectionYear($row[25]),
            'e_12' => $this->parseElectionYear($row[26]),
            'e_13' => $this->parseElectionYear($row[27]),
            'e_14' => $this->parseElectionYear($row[28]),
            'e_15' => $this->parseElectionYear($row[29]),
            'e_16' => $this->parseElectionYear($row[30]),
        ];
        
        for ($i = 1; $i <= 16; $i++) {
            $data["e_".$i] = $this->parseElectionYear($row[$i + 14]);
        }
        
        $voter = Voter::create($data);
        
        $voter->republican_votes = $this->getRepublicanVotes($voter);
        $voter->democrat_votes = $this->getDemocraticVotes($voter);
        $voter->nonparty_votes = $this->getNonPartyVotes($voter);
        $voter->total_votes = $voter->republican_votes + $voter->democrat_votes + $voter->nonparty_votes;
        
        $voter->save();
    }
    
    /**
     * Parses our address into house number and street.
     *
     * @param $address
     * @return array
     */
    protected function parseAddress($address)
    {
        $array = explode(' ', $address, 2);
        
        return [
            $array[0],
            $array[1]
        ];
    }
    
    /**
     * Parse the phone number.
     *
     * @param $phoneNumber
     * @return null
     */
    protected function parsePhoneNumber($phoneNumber)
    {
        // simple pattern
        $pattern = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
    
        preg_match($pattern, $phoneNumber, $matches);
        
        if ($matches) {
            return $matches[0];
        }
        
        return null;
    }
    
    /**
     * @param $data
     * @return mixed
     */
    protected function parseElectionYear($data)
    {
        return str_replace(' ', '', $data);
    }
    
    /**
     * @return int
     */
    protected function getRepublicanVotes($voter)
    {
        $totalVotes = 0;
        
        $republicanVotes = [
            'YRY',
            'NRY',
            'YRN',
            'NRN',
        ];
        
        foreach($republicanVotes as $republicanVote) {
            foreach ($this->getElectionYears() as $electionYear) {
                if ($voter->$electionYear == $republicanVote) {
                    $totalVotes++;
                }
            }
        }
        
        return $totalVotes;
    }
    
    /**
     * @param $voter
     * @return int
     */
    protected function getDemocraticVotes($voter)
    {
        $totalVotes = 0;
        
        $democraticVotes = [
            'YDY',
            'NDY',
            'YDN',
            'NDN',
        ];
        
        foreach($democraticVotes as $democraticVote) {
            foreach ($this->getElectionYears() as $electionYear) {
                if ($voter->$electionYear == $democraticVote) {
                    $totalVotes++;
                }
            }
        }
        
        return $totalVotes;
    }
    
    /**
     * @return int
     */
    protected function getNonPartyVotes($voter)
    {
        $totalVotes = 0;
        
        $votes = [
            'YY',
            'NY',
            'YN',
            'NN',
        ];
        
        foreach($votes as $vote) {
            foreach ($this->getElectionYears() as $electionYear) {
                if ($voter->$electionYear == $vote) {
                    $totalVotes++;
                }
            }
        }
        
        return $totalVotes;
    }
    
    protected function getElectionYears()
    {
        $electionYears = [];
        
        for ($i = 1; $i <= 16; $i++) {
            array_push($electionYears, 'e_' . $i);
        }
        
        return $electionYears;
    }
    
    /**
     * @param $voter
     * @return mixed
     */
    protected function noVote($voter)
    {
        return $voter->whereNull('e_1')
            ->whereNull('e_2')
            ->whereNull('e_3')
            ->whereNull('e_4')
            ->whereNull('e_5')
            ->whereNull('e_6')
            ->whereNull('e_7')
            ->whereNull('e_8')
            ->whereNull('e_9')
            ->whereNull('e_10')
            ->whereNull('e_11')
            ->whereNull('e_12')
            ->whereNull('e_13')
            ->whereNull('e_14')
            ->whereNull('e_15')
            ->whereNull('e_16')->count();
    }
    
    
}
