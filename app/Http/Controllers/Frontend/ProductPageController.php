<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    function index(Request $request): View
    {
        $products = Product::with(['images' => function($query){
            $query->limit(2);
        }, 'store:id,name', 'primaryVariant'])
        ->where('status', 'active')->where('approved_status', 'approved')->paginate(20);
        return view('frontend.pages.product', compact('products'));
    }

    function show(string $slug): View
    {
        $product = Product::with(['images:id,path,product_id'])
            ->where('slug', $slug)->firstOrFail();
        return view('frontend.pages.product-show', compact('product'));
    }

}
