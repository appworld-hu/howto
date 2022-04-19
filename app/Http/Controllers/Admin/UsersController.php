<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Contracts\UserRepositoryInterface;
use App\Http\Controllers\AbstractCrudController;

class UsersController extends AbstractCrudController
{
    protected string $view = 'admin.users';

    protected string $title = 'users.title';

    protected string $pluralTitle = 'users.title_plural';

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
