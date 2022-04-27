<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface extends CrudRepositoryInterface
{
    public function newInstance(array $data = []): Model|Product;

    public function findById(int $id): Model|Product;

    public function save(Model|Product $model): Model|Product;

    public function findByName(string $name): Model|Product;

    public function deleteById(int $id): void;  

}
