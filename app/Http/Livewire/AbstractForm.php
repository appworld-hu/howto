<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Contracts\CrudRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

abstract class AbstractForm extends Component
{
    public Model $model;

    public ?int $modelId = null;

    protected string $viewFolder;

    protected string $routeParent;

    protected array $rules = [
        'model.name' => 'required|max:50|min:4',
    ];

    protected CrudRepositoryInterface $repository;

    public function submit()
    {
        $this->validate();

        $this->save();

        $this->afterSubmit();

        session()->flash('message', __('tools.message.saved'));

        redirect()->route('admin.'.$this->routeParent.'.index');
    }

    public function mount(): void
    {
        if (null === $this->modelId) {
            $this->model = $this->repository->newInstance();
        } else {
            $this->model = $this->repository->findById($this->modelId);
        }
    }

    public function render(): View
    {
        return view('admin.'.$this->viewFolder.'.form');
    }

    protected function afterSubmit(): void
    {
    }

    protected function save()
    {
        $this->repository->save($this->model);
    }
}
