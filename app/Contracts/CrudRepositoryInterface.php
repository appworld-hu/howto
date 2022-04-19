<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryInterface
{
    public function newInstance(array $data = []): Model;

    public function findById(int $id): Model;

    public function save(Model $model): Model;

    public function findAll(): Paginator;

    public function deleteById(int $id): void;

    public function searchQuery(?string $search): Builder;

    public function searchTrashedQuery(?string $search): Builder;

    public function search(?string $search): Paginator;

    public function allToArray(string $keyField = 'id', string $nameField = 'name'): array;
}
