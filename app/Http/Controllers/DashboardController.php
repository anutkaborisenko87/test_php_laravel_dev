<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Lot;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        $lots = auth()->user()->lots;
        $categories = Category::all();
        return view('dashboard.index', compact('lots', 'categories'));
    }
}
