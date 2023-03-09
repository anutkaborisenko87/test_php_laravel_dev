<?php

namespace App\Http\Controllers;

use App\Http\Resources\LotResource;
use App\Http\Resources\UserResource;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function usersList()
    {
        $users = Lot::with('user', 'categories')->get();

        return LotResource::collection($users);
    }
}
