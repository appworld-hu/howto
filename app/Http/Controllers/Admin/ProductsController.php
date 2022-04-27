<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Contracts\ProductRepositoryInterface;
use App\Http\Controllers\AbstractCrudController;

class ProductsController extends AbstractCrudController
{
    protected string $view = 'admin.products';

    protected string $title = 'products.title';

    protected string $pluralTitle = 'products.title_plural';

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
