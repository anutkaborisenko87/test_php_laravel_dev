<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
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

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->validated();
        $newCat = Category::create([
            'title' => $data['title'],
            'description' => $data['description']
        ]);
        if (isset($data['lots'])) {
            foreach ($data['lots'] as $lot) {
                $newCat->lots()->attach($lot);
            }
        }
        return redirect()->route('admin-dashboard.index')->with('success', 'Category created successfully');
    }
    public function update(CreateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->title = $data['title'];
        $category->description = $data['description'];
        $category->save();
        $catLots = $category->lots()->pluck('id')->toArray();
        if (isset($data['lots'])) {
            foreach ($catLots as $lot) {
                if (!in_array($lot, $data['lots'])) {
                    $category->lots()->detach([$lot]);
                }
            }
            foreach ($data['lots'] as $lot) {
                if (!in_array($lot, $catLots)) {
                    $category->lots()->attach($lot);
                }
            }
        }
        return redirect()->route('admin-dashboard.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin-dashboard.index')->with('success', 'Category deleted successfully');
    }

}
