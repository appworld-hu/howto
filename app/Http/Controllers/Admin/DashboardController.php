<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;

class DashboardController
{
    public function show(): View
    {
        return view('admin.dashboard.show');
    }
}
