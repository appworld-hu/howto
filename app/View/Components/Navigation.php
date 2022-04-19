<?php

declare(strict_types=1);

namespace App\View\Components;

use App\View\Models\NavigationItem;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component
{
    public array $items;

    public function render(): View
    {
        foreach (config('navigation') as $itemConfig) {
            $this->items[] = NavigationItem::make($itemConfig);
        }

        return view('components.navigation');
    }
}
