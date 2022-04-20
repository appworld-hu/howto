<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @property User $model
 */
class UserForm extends AbstractForm
{
    protected string $viewFolder = 'users';

    protected string $routeParent = 'users';

    public ?string $password = null;

    protected array $rules = [
        'model.name' => 'required|max:50|min:4',
        'model.email' => 'required|email',
    ];

    protected function rules(): array
    {
        if($this->model->exists) {
            $this->rules['password'] = 'nullable|min:6';
        } else {
            $this->rules['password'] = 'required|min:6';
        }

        return $this->rules;
    }

    public function boot(UserRepositoryInterface $repository): void
    {
        $this->repository = $repository;
    }

    protected function save()
    {
        if(null !== $this->password) {
            $this->model->password = Hash::make($this->password);
        }

        $this->repository->save($this->model);
    }
}
