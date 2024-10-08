<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MessageRepository;
use App\Models\Message;
use App\Validators\MessageValidator;

/**
 * Class MessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MessageRepositoryEloquent extends BaseRepository implements MessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Message::class;
    }

    /**
     * Use Validator
     */
    public function validator()
    {
        return MessageValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
