<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\FebricType;
use App\Models\Color;
use App\Models\SizeMaster;
use App\Models\ProductImage;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    //
    public function Products(){
        $data['products'] = Product::all();
        return view("front/products/index",$data);
    }

    public function createProduct(){
        $data['category'] = Category::all();
        $data['febrictype'] = FebricType::all();
        $data['colors'] = ColorMaster::all();
        $data['sizes'] = SizeMaster::all();
        return view("front/products/create",$data);
    }

    public function productStore(Request $request){
        $product_name = $request->product_name;
        $img = $request->img;
        $galary_img = $request->galary_img;
        $product_type = $request->product_type;
        $fabric_type = $request->fabric_type;
        $gender_type = $request->gender_type;
        $product_details =$request->product_details;


    }
}
