<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Policy;
use App\Models\DocumentProd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;
use Validator;
use DB;
use Hash;


class CmsController extends Controller
{
    public function privacyPolicy(Request $request)
    {
        //This function is for add/update/show the privacy policy
        $privacy = Policy::where('policy_type', 3)->first();
        if ($request->isMethod('post')) 
        {
            
            $policy_content=$request->policy_content;
            if($privacy)
            {
                //Now update the privacy Policy
                DB::table('policy')
                  ->where('policy_type', 3)
                  ->update([
                  'policy_content' => $request->policy_content
              ]);

              Session::flash('message', 'Privacy Policy Updated Sucessfully!');
              return redirect()->to('/admin/privacyPolicy');
            }
            else
            {
                //add the privacy Policy
                $user = new Policy;
				
				$user->policy_content = $request->policy_content;
				$user->policy_type = "3";
				$user->is_active = "1";
				$user->created_at = date('Y-m-d H:i:s');
				$user->save();
				$user_id = $user->policy_id;
				Session::flash('message', 'Policy added Sucessfully!');
	
				return redirect()->to('/admin/privacyPolicy');
            }
        }
        return view('admin.cms.privacy_policy',compact('privacy'));
    }
    public function aboutUs(Request $request)
    {
        //This function is for add/update/show the privacy policy
        $about = Policy::where('policy_type', 2)->first();
        if ($request->isMethod('post')) 
        {
            
            $policy_content=$request->policy_content;
            if($about)
            {
                //Now update the privacy Policy
                DB::table('policy')
                  ->where('policy_type', 2)
                  ->update([
                  'policy_content' => $request->policy_content
              ]);

              Session::flash('message', 'About Us Updated Sucessfully!');
              return redirect()->to('/admin/aboutUs');
            }
            else
            {
                //add the privacy Policy
                $user = new Policy;
				
				$user->policy_content = $request->policy_content;
				$user->policy_type = "2";
				$user->is_active = "1";
				$user->created_at = date('Y-m-d H:i:s');
				$user->save();
				$user_id = $user->policy_id;
				Session::flash('message', 'About Us added Sucessfully!');
	
				return redirect()->to('/admin/aboutUs');
            }
        }
        return view('admin.cms.about_us',compact('about'));
    }
    public function termsConditions(Request $request)
    {
        //This function is for add/update/show the privacy policy
        $terms = Policy::where('policy_type', 1)->first();
        if ($request->isMethod('post')) 
        {
            
            $policy_content=$request->policy_content;
            if($terms)
            {
                //Now update the privacy Policy
                DB::table('policy')
                  ->where('policy_type', 1)
                  ->update([
                  'policy_content' => $request->policy_content
              ]);

              Session::flash('message', 'Terms & Conditions Updated Sucessfully!');
              return redirect()->to('/admin/termsConditions');
            }
            else
            {
                //add the privacy Policy
                $user = new Policy;
				
				$user->policy_content = $request->policy_content;
				$user->policy_type = "1";
				$user->is_active = "1";
				$user->created_at = date('Y-m-d H:i:s');
				$user->save();
				$user_id = $user->policy_id;
				Session::flash('message', 'Terms & Conditions added Sucessfully!');
	
				return redirect()->to('/admin/termsConditions');
            }
        }
        return view('admin.cms.terms_conditions',compact('terms'));
    }
}