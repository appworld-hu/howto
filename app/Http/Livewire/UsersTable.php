<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class UsersTable extends DataTableComponent
{
    public array $columnSearch = [
        'name' => null,
        'email' => null,
    ];
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Name')
                ->sortable()
                ->searchable(),
            Column::make('E-mail', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Created At')
                ->sortable(),
            Column::make('Updated At')
                ->sortable(),
            LinkColumn::make('', 'id')
                ->title(static fn ($row) => 'Edit')
                ->location(static fn ($row) => route('admin.users.edit', $row)),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'activate' => 'Activate',
            'deactivate' => 'Deactivate',
        ];
    }
}
