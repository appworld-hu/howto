<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;

class DashboardController
{
    public function show(): View
    {
        return view('admin.dashboard.show');
    }
}
