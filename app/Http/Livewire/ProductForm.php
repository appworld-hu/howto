<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

/**
 * @property Product $model
 */
class ProductForm extends AbstractForm
{
    protected string $viewFolder = 'products';

    protected string $routeParent = 'products';

    protected array $rules = [
        'model.name' => 'required|max:50|min:4',
        'model.description' => ''
    ];

    public function boot(ProductRepositoryInterface $repository): void
    {
        $this->repository = $repository;
    }

    protected function rules(): array
    {
        return $this->rules;
    }


    protected function save()
    {
        $this->repository->save($this->model);
    }

    protected function delete()
    {
        $this->repository->deleteById($this->model);
    }
}
