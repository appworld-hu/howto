<?php

declare(strict_types=1);

namespace App\View\Models;

use Illuminate\Support\Facades\Route;

class NavigationItem
{
    public string $title;

    public ?string $icon = null;

    public string $route;

    public ?string $link = null;

    public bool $active = false;

    public array $items = [];

    public bool $accordion = false;

    public function __construct(array $attributes)
    {
        $this->title = __('navigation.'.$attributes['title']);

        $this->prepareActiveAttributes($attributes);
        $this->prepareLinkAttributes($attributes);
        $this->prepareIconAttributes($attributes);
        $this->prepareSubItems($attributes);
    }

    public static function make(array $attributes): self
    {
        return new self($attributes);
    }

    public function makeActivePattern($route): string
    {
        $items = explode('.', $route);
        unset($items[\count($items) - 1]);

        return implode('.', $items).'*';
    }

    private function prepareActiveAttributes(array $attributes): void
    {
        if (isset($attributes['active'])) {
            $activePattern = $attributes['active'];
        } elseif (isset($attributes['route'])) {
            $activePattern = $this->makeActivePattern($attributes['route']);
        }

        if (isset($activePattern)) {
            $this->active = Route::is($activePattern);
        }
    }

    private function prepareLinkAttributes(array $attributes): void
    {
        if (isset($attributes['route'])) {
            $this->route = $attributes['route'];
            $this->link = route($this->route);
        } elseif (isset($attributes['link'])) {
            $this->link = $attributes['link'];
        }
    }

    private function prepareSubItems(array $attributes): void
    {
        if (isset($attributes['items']) && \is_array($attributes['items'])) {
            $this->accordion = true;

            foreach ($attributes['items'] as $item) {
                $itemInstance = new self($item);

                if ($itemInstance->active) {
                    $this->active = true;
                }

                $this->items[] = $itemInstance;
            }
        }
    }

    private function prepareIconAttributes(array $attributes): void
    {
        if (isset($attributes['icon'])) {
            $this->icon = $attributes['icon'];
        }
    }
}
