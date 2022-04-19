<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends AbstractCrudRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByEmail(string $email): Model
    {
        $query = $this->newQuery();

        $query->with($this->itemRelations);

        return $query->where('email', '=', $email)->firstOrFail();
    }
}
