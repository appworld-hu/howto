<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\CrudRepositoryInterface;
use App\Models\AbstractModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractCrudRepository implements CrudRepositoryInterface
{
    protected AbstractModel|Model $model;

    protected array $itemRelations = [];

    protected array $paginateListColumns = ['*'];

    protected int $paginatePerPage = 15;

    protected string $paginatePageName = 'page';

    protected array $searchFields = ['name'];

    public function newInstance(array $data = []): Model
    {
        $model = $this->model->newInstance($data);

        $model->with($this->itemRelations);

        return $model;
    }

    public function findById(int $id): Model
    {
        $query = $this->newQuery();

        $query->with($this->itemRelations);

        return $query->where('id', $id)->firstOrFail();
    }

    public function save(Model $model): Model
    {
        $model->save();

        return $model;
    }

    public function findAll(): Paginator
    {
        return $this->newQuery()
            ->paginate($this->paginatePerPage, $this->paginateListColumns, $this->paginatePageName);
    }

    public function deleteById(int $id): void
    {
        $this->findById($id)->delete();
    }

    public function searchQuery(?string $search): Builder
    {
        $query = $this->newQuery();

        if (null !== $search) {
            foreach ($this->searchFields as $field) {
                $query->orWhere($field, 'LIKE', "%{$search}%");
            }
        }

        return $query;
    }

    public function searchTrashedQuery(?string $search): Builder
    {
        $query = $this->newQuery(true);

        if (null !== $search) {
            foreach ($this->searchFields as $field) {
                $query->orWhere($field, 'LIKE', "%{$search}%");
            }
        }

        return $query;
    }

    public function search(?string $search): Paginator
    {
        return $this->searchQuery($search)
            ->paginate($this->paginatePerPage, $this->paginateListColumns, $this->paginatePageName);
    }

    public function allToArray(string $keyField = 'id', string $nameField = 'name'): array
    {
        return $this->newQuery()
            ->select([$nameField, $keyField])
            ->orderBy($nameField)
            ->get()->pluck($nameField, $keyField)->toArray();
    }

    public function setItemRelations(array $itemRelations): self
    {
        $this->itemRelations = $itemRelations;

        return $this;
    }

    protected function newQuery(bool $trashed = false): Builder
    {
        if ($trashed) {
            $query = $this->model->onlyTrashed();
        } else {
            $query = $this->model->newQuery();
        }

        return $query;
    }
}
