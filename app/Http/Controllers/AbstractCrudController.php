<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CrudRepositoryInterface;
use Illuminate\View\View;

class AbstractCrudController
{
    protected string $title;

    protected string $pluralTitle;

    protected string $view;

    protected CrudRepositoryInterface $repository;

    public function index(): View
    {
        $data = ['title' => $this->getTitle('crud.search_title', $this->pluralTitle), 'view' => $this->view];
        $data = array_merge($data, $this->indexIngredients());

        return view($this->view.'.index', $data);
    }

    public function trash(): View
    {
        $data = ['title' => $this->getTitle('crud.search_title', $this->pluralTitle), 'view' => $this->view];

        return view($this->view.'.trash', $data);
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $data = ['title' => $this->getTitle('crud.create_title', $this->title)];
        $data = array_merge($data, $this->createIngredients());

        return view($this->view.'.create', $data);
    }

    public function edit(int $id): \Illuminate\Contracts\View\View
    {
        $model = $this->repository->findById($id);
        $data = [
            'title' => $this->getTitle('crud.edit_title', $this->title),
            'model' => $model,
        ];

        $data = array_merge($data, $this->editIngredients());

        return view($this->view.'.edit', $data);
    }

    public function show(int $id): \Illuminate\Contracts\View\View
    {
        $model = $this->repository->findById($id);

        $data = [
            'title' => $this->getTitle('crud.show_title', $this->title),
            'model' => $model,
        ];

        $data = array_merge($data, $this->showIngredients());

        return view($this->view.'.show', $data);
    }

    protected function indexIngredients(): array
    {
        return [];
    }

    protected function createIngredients(): array
    {
        return [];
    }

    protected function editIngredients(): array
    {
        return [];
    }

    protected function showIngredients(): array
    {
        return [];
    }

    protected function getTitle(string $title, string $type): string
    {
        return __($title, ['type' => __($type)]);
    }
}
