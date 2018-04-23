<?php

namespace App\Repositories;

use App\Models\Nomination;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NominationRepository
 * @package App\Repositories
 * @version April 23, 2018, 1:08 pm UTC
 *
 * @method Nomination findWithoutFail($id, $columns = ['*'])
 * @method Nomination find($id, $columns = ['*'])
 * @method Nomination first($columns = ['*'])
*/
class NominationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'gender',
        'bio',
        'business_name',
        'reason_for_nomination',
        'linkedin_url',
        'no_of_nominations',
        'is_admin_selected',
        'is_won',
        'user_id',
        'category_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Nomination::class;
    }
}
