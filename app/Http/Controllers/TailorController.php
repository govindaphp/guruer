<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;


class TailorController extends Controller
{
    
    public function index(){
        $data['tailors']   = Vendor::where('vendor_type','1')->get();
		return view("front/Tailor/tailorlist",$data);
	}


    public function tailorDetails($id){
        $data['tailor'] = Vendor::where('vendor_id',$id)->first();
		return view("front/Tailor/tailordetails",$data);
	}

    


}
