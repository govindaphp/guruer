<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\Subject;
use App\Models\GuruerSubject;
use App\Models\UserLanguage;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class CustomerController extends Controller
{
    public function customerDashboard()
    {
        //This function is for customer dashboard
        if (Auth::guard('user')->check()) {
			// Redirect to the user dashboard if authenticated
			  return view('front.user.customer_dash');
      }
      else{
        return redirect()->to('/login');
      }
    }

    public function updateProfile(Request $request)
    {
        //This function is for update the customer profile
        $customer = User::where('id', auth('user')->id())->first();
        $imageName=$customer->profile_image;
        if ($request->isMethod('post')) 
        {
            if ($request->hasFile('profile_image')) 
            {
                $image = $request->file('profile_image');
                $existingFilePath = public_path('/admin/uploads/user/' . $imageName);
                if (!empty($image)  && $image !== null   &&  !empty($imageName) && $imageName !== null && file_exists($existingFilePath)) {
                  unlink($existingFilePath);
                }
                $imageName = "cus".time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('/admin/uploads/user'), $imageName);
            }

           DB::table('users')
                    ->where('id', auth('user')->id())
                    ->update([
                    'first_name' => trim($request->first_name),
                    'last_name' => trim($request->last_name),
                    'profile_image' => $imageName,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'country_id'=>$request->country_id,
                    'city_id' => $request->city_id,
                    'state_id' => $request->state_id,
                    'zipcode' => $request->zipcode,
                    'price'   => $request->price,
                ]);

              UserLanguage::where('user_id', auth('user')->id())->delete();
              GuruerSubject::where('user_id', auth('user')->id())->delete();

              $languages = $request->language;

              foreach($languages as $key=> $value)
              {
                $userLanguage = new UserLanguage();
                $userLanguage->user_id      = auth('user')->id();
                $userLanguage->language_id	= $value;
                $userLanguage->save();
              }

              $subjects = $request->subjects;

              foreach($subjects as $key=> $value)
              {
                $userSubject = new GuruerSubject();
                $userSubject->user_id      = auth('user')->id();
                $userSubject->subject_id   = $value;
                $userSubject->save();
              }
          Session::flash('message', 'Your Profile Updated Sucessfully!');
          return redirect()->to('/customerProfile');
        }

        $countries = DB::table('master_country')->select('country_id','country_name')->where('country_status',1)->get();
        $state = DB::table('master_state')->select('state_id','state_name')->orderBy('state_name', 'asc')->get();
        $city = DB::table('master_city')->select('city_id','city_name')->orderBy('city_name', 'asc')->get();
        $language = Language::all();
        $UserLanguage = UserLanguage::where('user_id', auth('user')->id())->get();
        $subjects = Subject::where('is_deleted','0')->get();
        $userSubject = GuruerSubject::where('user_id', auth('user')->id())->get();

        return view('front.user.customer_profile',compact('customer','countries','state','city','language','UserLanguage','subjects','userSubject'));
    }

    public function customerMessages(){
      $user_id = auth('user')->id();
      $data['user_id'] =  $user_id;
      $data['allMerchecnts'] = User::where('user_type','2')->get();
      return view('front.user.message',$data);
    }
    
    public function customer_delete_it(){
		$user_id = auth('user')->id();
		$data['user_id'] =  $user_id;
		$data['allUsers'] = User::where('user_type','2')->get();
		return view('front.user.message_delete_it',$data);
	  }

}