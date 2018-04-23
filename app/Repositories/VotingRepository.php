<?php

namespace App\Repositories;

use App\Models\Voting;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class VotingRepository
 * @package App\Repositories
 * @version April 23, 2018, 1:10 pm UTC
 *
 * @method Voting findWithoutFail($id, $columns = ['*'])
 * @method Voting find($id, $columns = ['*'])
 * @method Voting first($columns = ['*'])
*/
class VotingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'nomination_id',
        'category_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Voting::class;
    }
}
