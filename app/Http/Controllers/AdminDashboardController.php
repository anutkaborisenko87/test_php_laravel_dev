<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Lot;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $categories = Category::with('lots')->get();
        $lots = Lot::all();
        return view('adminDashboard.index', compact('categories', 'lots'));
    }
}
