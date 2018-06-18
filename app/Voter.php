<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Voter extends Model
{
    use LadaCacheTrait;
    
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
    public function scopeHasVoted(Builder $query)
    {
        return $query->where('total_votes', '>=', 1);
    }
    
    /**
     * Default order by precinct, street, house number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefaultOrderBy(Builder $query)
    {
        return $query->orderBy('street_address', 'asc')
            ->orderBy('house_number', 'asc')
            ->orderBy('last_name', 'asc');
    }
    
}
