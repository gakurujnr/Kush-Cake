<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomizationOption;
use App\Models\Product;
use App\Models\ProductCustomization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomizationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Customization/Index', [
                'products' => Product::all(),
                'customizations' => CustomizationOption::all()
            ]);
    }

    public function store(Request $request)
    {
        $customization = new CustomizationOption();
        $customization->name = $request->name;
        $customization->description = $request->description;
        $customization->save();

        //save the product customizations
        $prodCustomizations = new ProductCustomization();
        $prodCustomizations->product_id = $request->product_id;
        $prodCustomizations->customization_option_id = $customization->id;
        $prodCustomizations->save();

        return to_route('admin.customization.index');
    }
}
