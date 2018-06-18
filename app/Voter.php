<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_id',
        'last_name',
        'first_name',
        'title',
        'house_number',
        'street_address',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'phone',
        'pct_nbr',
        'pct',
        'pct_sub',
        'mail',
        'mail_city',
        'mail_state',
        'mail_zip',
        'e_1',
        'e_2',
        'e_3',
        'e_4',
        'e_5',
        'e_6',
        'e_7',
        'e_8',
        'e_9',
        'e_10',
        'e_11',
        'e_12',
        'e_13',
        'e_14',
        'e_15',
        'e_16',
    ];
    
    /**
     * Only shows voters who have voted in the last 4 elections.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeVotedInLastFour(Builder $query)
    {
        return $query->whereNotNull('e_1')
            ->whereNotNull('e_3')
            ->whereNotNull('e_4')
            ->whereNotNull('e_6');
    }
    
    /**
     * Returns array containing the voting codes that represent a democratic vote.
     *
     * @return array
     */
    public function getDemocratVoteCodes()
    {
        return [
            'YDY',
            'NDY',
            'YDN',
            'NDN',
        ];
    }
    
    /**
     * Returns array containing the voting codes that represent a republican vote.
     *
     * @return array
     */
    public function getRepublicanVoteCodes()
    {
        return [
            'YRY',
            'NRY',
            'YRN',
            'NRN',
        ];
    }
    
    /**
     * Returns array containing the voting codes that represent a non-party vote.
     *
     * @return array
     */
    public function getNonPartyVoteCodes()
    {
        return [
            'YY',
            'NY',
            'YN',
            'NN',
        ];
    }
}
