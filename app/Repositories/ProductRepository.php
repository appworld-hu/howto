<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends AbstractCrudRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function findByName(string $name): Model
    {
        $query = $this->newQuery();

        $query->with($this->itemRelations);

        return $query->where('name', '=', $name)->firstOrFail();
    }
}
