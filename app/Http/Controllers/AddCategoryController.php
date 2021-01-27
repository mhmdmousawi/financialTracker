<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Logo;
use App\Category;

class AddCategoryController extends Controller
{
    public function index()
    {
        $logos = Logo::all();
        return view('category.add')->with('logos',$logos);
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:income,expense,saving',
            'title' => 'required|max:255',
            'logo_id' => 'required|exists:logos,id',
        ]);

        $category = new Category;
        $category->profile_id = Auth::user()->profile->id;
        $category->type = $request->type;
        $category->title = $request->title;
        $category->logo_id = $request->logo_id;
        $category->save();

        return redirect('/dashboard/overview');
    }
}
