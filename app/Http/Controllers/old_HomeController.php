<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\DocumentProd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use DB;
use Hash;

class HomeController extends Controller{

	public function index(){
		return view("front/index");
	}
	/*********************[Customer Auth ]*****************************/
	public function login()
	{
		//This function is for login 
		return view("login");
	}
	public function loginchk(Request $request)
	{
		//This function is for login the customer
		$request->validate([
			"email" => "required|email",
			"password" => "required"
		]);
		
		if (Auth::guard("user")->attempt([
			"email_id" => $request->email,
			"password" => $request->password
		])) 
		{
			return redirect()->to('/customer');
		}
		else {
			// Flash a message and redirect back on failure
			return back()->with('error','Email  id & Password is incorrect');
		}
			
	}
	public function register()
	{
		//This is for new registeration
		return view("register");
	}
	public function signup(Request $request)
	{
		//This function is for signup the user
		$request->validate([
			"email_id" => "required|email",
			"password" => "required"
		]);
		$user = User::where('email_id', $request->email_id)->first();
		if($user)
		{
			return back()->with('error','Email  id already exist as customer , please login');
		}
		else
		{
			$user = new User;
			$user->first_name = trim($request->first_name);
			$user->email_id = $request->email_id;
			$user->password = Hash::make($request->password);
			$user->user_status = "1";
			$user->customer_type = "0";
			$user->is_social= "0";
			$user->is_deleted= "0";
			$user->save();
			$user_id = $user->id;
			Session::flash('message', 'User Inserted Sucessfully!');

			return redirect()->to('/login');
		}
	}
	public function customer()
	{
		return view('front.user.dashboard');
	}
	/*********************[Customer Auth END ]*****************************/

	/*********************[Vendor Auth START]*****************************/
	public function vendorSignup(Request $request)
	{
		//This function is for signup the vendor
		
		if ($request->isMethod('post')) {
			
			$request->validate([
				"email_id" => "required|email",
				"password" => "required"
			]);
			$user = Vendor::where('email', $request->email_id)->first();
			if($user)
			{
				return back()->with('error','Email  id already exist as Vendor , please login');
			}
			else
			{
				$user = new Vendor;
				$user->name = trim($request->first_name);
				$user->email = $request->email_id;
				$user->password = Hash::make($request->password);
				$user->vendor_status = "1";
				$user->vendor_type = "0";
				$user->is_social= "0";
				$user->is_deleted= "0";
				$user->save();
				$user_id = $user->id;
				Session::flash('message', 'User Inserted Sucessfully!');
	
				return redirect()->to('/vendorLogin');
			}

		}
		return view("vendorregistor");
	}
	public function vendorLogin(Request $request)
	{
		//This function is for login the vendor
		if ($request->isMethod('post')) {
		
			if (Auth::guard("vendor")->attempt([
				"email" => $request->email,
				"password" => $request->password
			])) 
			{
				return redirect()->to('/vendors');
			}
			else {
				// Flash a message and redirect back on failure
				return back()->with('error','Email  id & Password is incorrect');
			}
		}
		return view('vendorlogin');
	}
	public function vendors()
	{
		return view('front.vendor.dashboard');
	}
	/*********************[Vendor Auth END]*****************************/
	public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

	public function searchHome(Request $request)
	{
		//This function is for search for home pages
		if($request->isMethod('post'))
		{
			$keyword=$request->keyword;
			
		}
	}
	
	public function browseFebrics(Request $request)
	{
		return view("front/browse_febric");
	}
	public function febricMarchent(Request $request)
	{
		return view("front/febric_marchent");
	}
}