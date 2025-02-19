<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 * 
 * @package  App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @param Request $request The HTTP request instance.
     * @return \Illuminate\Contracts\View\View The view for displaying the dashboard.
     */
    public function index(Request $request)
    {
        return view('admin.dashboard');
    }

    public function terms(Request $request)
    {
        $termConditions = Auth::user()->client->hotel->term_conditions ?? null;
        $termConditions = $termConditions ? explode("\r\n", $termConditions) : [];
        return view('admin.terms', compact('termConditions'));
    }
}
