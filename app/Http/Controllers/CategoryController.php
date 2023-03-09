<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function indexApi()
    {
        $categories = Category::with('lots')->get();
        return CategoryResource::collection($categories);
    }

    public function getCategoriesLots(Request $request)
    {
        $category_ids = $request->categories;
        $categories = Category::whereIn('id', $category_ids)->with('lots')->get();
        return CategoryResource::collection($categories);
    }
}
