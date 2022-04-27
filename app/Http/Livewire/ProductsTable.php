<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Product;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ProductsTable extends DataTableComponent
{
    public array $columnSearch = [
        'name' => null,
        'description' => null,
    ];
    protected $model = Product::class;

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
            Column::make('Description')
                ->sortable()
                ->searchable(),
            Column::make('Created At')
                ->sortable(),
            Column::make('Updated At')
                ->sortable(),
            LinkColumn::make('', 'id')
                ->title(static fn ($row) => 'Edit')
                ->location(static fn ($row) => route('admin.products.edit', $row)),     
  
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
