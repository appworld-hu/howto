<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends CrudRepositoryInterface
{
    public function newInstance(array $data = []): Model|User;

    public function findById(int $id): Model|User;

    public function save(Model|User $model): Model|User;

    public function findByEmail(string $email): Model|User;
}
