<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Libraries\BigBlueButton;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\ChatStatus;
use App\Models\ChatSharedFile;
use Carbon\Carbon;
use App\Models\Language;
use App\Models\Subject;
use App\Models\GuruerSubject;
use App\Models\UserLanguage;
use App\Models\Category;
use App\Models\SubCate;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;


class VendorController extends Controller
{
    public function vendorDashboard()
    {
        //This function is for vendor dashboard
			return view("front.vendor.vendor_dash");
    }

    public function ProfileSetting(Request $request)
	{
		$vendorId				= Auth::guard('user')->user()->id;
        $data['customer'] 		= User::where('id', $vendorId)->first();
        $data['countries'] 		= DB::table('master_country')->select('country_id','country_name')->where('country_status',1)->get();
        $data['state'] 			= DB::table('master_state')
										->select('state_id', 'state_name')
										->orderBy('state_name', 'asc') 
										->get();
        $data['city']  			= DB::table('master_city')->select('city_id','city_name')->orderBy('city_name', 'asc') ->get();
		$data['language'] 		= Language::all();
        $data['UserLanguage'] 	= UserLanguage::where('user_id', $vendorId)->get();
        $data['subjects'] 		= Subject::where('is_deleted','0')->get();
        $data['userSubject'] 	= GuruerSubject::where('user_id', $vendorId)->get();

		return view("front.vendor.guru_profile",$data);
	}

	public function profile_update(Request $request)
	{
		$customer = User::where('id', auth('user')->id())->first();
        $imageName=$customer->profile_image;

            if ($request->hasFile('profile_image')) 
			{
                $image = $request->file('profile_image');
				$existingFilePath = public_path('/admin/uploads/user/' . $imageName);
                if (!empty($image) && $image !== null   &&  !empty($imageName) && $imageName !== null  && file_exists($existingFilePath)) {
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
              

              $languages = $request->language;
              foreach($languages as $key=> $value)
			  {
                $userLanguage = new UserLanguage();
                $userLanguage->user_id      = auth('user')->id();
                $userLanguage->language_id	= $value;
                $userLanguage->save();
              }

             

			// Handle video type and data
			$videoType = $request->video_type; // 1 for embed, 2 for MP4
			$videoData = null;

			if ($videoType == 1) { // Embed
				$videoData = trim($request->embed_url); // Assuming embed video URL input field
			} elseif ($videoType == 2 && $request->hasFile('video_file')) { // MP4 file upload
				$videoFile = $request->file('video_file');
				$videoData = "video_" . time() . '.' . $videoFile->getClientOriginalExtension();


				// Define the existing file path
				$existingFilePath = public_path('/admin/uploads/videos-profile/' . $customer->video_data);
				// Check if the existing video file exists and delete it
				if (!empty($customer->video_data) && file_exists($existingFilePath)) {
					unlink($existingFilePath);
				}
				$videoFile->move(public_path('/admin/uploads/videos-profile'), $videoData);
			}

			
			$updateData = [
			    'video_type' => $videoType, // Always update video_type
			];
			// Only include video_data if $videoData is not null or blank
			if (!empty($videoData)) {
			    $updateData['video_data'] = $videoData;
			}
			// Insert or update video details in the users table
			DB::table('users')->updateOrInsert(
			    ['id' => auth('user')->id()],
			    $updateData
			);

        Session::flash('message', 'Profile Update Sucessfully!');
        return redirect()->to('/ProfileSetting');
    }
	public function updateSubject()
	{
		//This function is for update the guru subject
		$user_id=auth('user')->id();

		$data['category'] = DB::table('category')->select('id','category_name')->where('is_deleted',0)->where('is_active',1)->get();

		$data['subcat'] = DB::table('guruer_subjects')
							->where('user_id', $user_id)
							->select(
								'subcategory_id', 
								DB::raw('MAX(id) as id') ,DB::raw('MAX(category_id) as category_id'),
								DB::raw("GROUP_CONCAT(subject_id) as subject_id")
							)
							->groupBy('subcategory_id')
							->get();


		return view('front.vendor.guru_subject',$data);
	}

	public function getSubcategory(Request $request)
	{
		//This function is used for ajax
		$categoryId=$request->categoryId;
		$subcategories = DB::table('sub_category')->select('id','sub_cat_name')->where('category_id',$categoryId)->where('is_deleted',0)->where('is_active',1)->get();
        return response()->json($subcategories);
	}
	public function getSubject(Request $request)
	{
		//This function is user to get subject list in ajax
		$subcategoryId=$request->subcategoryId;
		$subcategories = DB::table('subjects')->select('id','subject_name')->where('subcategory_id',$subcategoryId)->where('is_deleted',0)->where('is_active',1)->get();
		
        return response()->json($subcategories);
	}
	public function guruSubject(Request $request)
	{
		//This function is for update 
		$subject_id=$request->subject_id;
		$user_id=auth('user')->id();
		
		GuruerSubject::where('user_id', auth('user')->id())->delete();

		foreach ($subject_id as $value) {
			$subject = DB::table('subjects')
							->select('category_id', 'subcategory_id')
							->where('id', $value)
							->first();
		
			if ($subject) {
				// Check if the record already exists
				$exists = DB::table('guruer_subjects')
					->where([
						['user_id', '=', auth('user')->id()],
						['subject_id', '=', $value],
						['category_id', '=', $subject->category_id],
						['subcategory_id', '=', $subject->subcategory_id]
					])->exists();
		
				// Insert only if it doesn't exist
				if (!$exists) {
					$userSubject = new GuruerSubject();
					$userSubject->user_id = auth('user')->id();
					$userSubject->subject_id = $value;
					$userSubject->category_id = $subject->category_id;
					$userSubject->subcategory_id = $subject->subcategory_id;
					$userSubject->save();
				}
			}
		}
		Session::flash('message', 'Subjects Update Sucessfully!');
        return redirect()->to('/updateSubject');
	}
	public function vendor_wallet()
	{
		return view('front.vendor.guruer_wallet');
	}

	public function loadchatResults_ajax(Request $request)
	{
		$user = Auth::guard("user")->user();
		if (!$user) {
			return redirect()->route('login')->with('error', 'Please login to access your wishlist.');
		}

		if($user->user_type == 2)
		$value_u_t = 1;
		else
		$value_u_t = 2;

		$searchKeyword = $request->input('keyword');
		$data['allUsers'] = DB::table('users')
			->select(
				'users.id as id',
				'users.first_name',
				'users.last_name',
				'users.online_status',
				'users.profile_image'
			)
			->where('users.user_type', $value_u_t)  // Ensure the user is of type '2'
			->where('users.is_deleted', '0') // Ensure the user is not deleted
			->when($searchKeyword, function ($query, $searchKeyword) {
				$searchKeyword = trim($searchKeyword); // Remove leading and trailing whitespaces
				if (strlen($searchKeyword) > 0) { // Check if searchKeyword has at least one character
					$query->where(function ($q) use ($searchKeyword) {
						$q->where('users.first_name', 'LIKE', "{$searchKeyword}%")
						->orWhere('users.last_name', 'LIKE', "{$searchKeyword}%");
					}); // Filter users by first_name or last_name
				}
			})
			->get();


			// print_r($data);die;
		if($user->user_type == 2)
		return view('front.vendor.chat_ajax', $data);
		if($user->user_type == 1)
		return view('front.user.chat_ajax', $data);
	}

	public function vendorProduct()

	{

		//This function is for vendor product list

		$products = DB::table('products')

						->join('category', 'products.category_id', '=', 'category.category_id')

						->where('products.vendor_id', auth('vendor')->id())

						->where('products.is_deleted', '0')

						->select('products.*', 'category.category_name as category_name')

						->get();

		return view("front/vendor/product_list",compact('products'));

	}



	public function Catalogue()

	{

		//This function is for vendor product list

		$catalogues = Catalogue::where('is_active','1')->where('is_deleted','0')->get();

		return view("front/vendor/tailorcatalogue/catalogue_list",compact('catalogues'));

	}



	public function addCatalogue(Request $request, $id = null)

	{

		$catalogue_name	 = $request->catalogue_name;

		$start_price	 = $request->start_price;

		$category_id	 = $request->category_id;

		$gender_type	 = $request->gender_type;

		$vendor_id		 = auth('vendor')->id();







		$data['catalogue'] = '';

		if($id)

		{

            $data['catalogue'] = Catalogue::where('id', $id)->first();



        }

		if ($request->isMethod('post')) {

			if($request->catalogue_id){



				$updateCatalogue = Catalogue::where('id',$request->catalogue_id)->first();

				$updateCatalogue->vendor_id			= $vendor_id;

				$updateCatalogue->category_id		= $category_id;

				$updateCatalogue->catalogue_name	= $catalogue_name;

				$updateCatalogue->start_price		= $start_price;

				$updateCatalogue->category_id		= $category_id;

				$updateCatalogue->gender_type		= $gender_type;

				$updateCatalogue->is_active		= '1';

				$updateCatalogue->is_deleted		= '0';

				$updateCatalogue->save();





				Session::flash('message', 'Catalogue Update Sucessfully!');

				return redirect()->to('/Catalogue');



			}else{



				$newCatalogue = new Catalogue();

				$newCatalogue->vendor_id		= $vendor_id;

				$newCatalogue->category_id	= $category_id;

				$newCatalogue->catalogue_name	= $catalogue_name;

				$newCatalogue->start_price		= $start_price;

				$newCatalogue->category_id		= $category_id;

				$newCatalogue->gender_type		= $gender_type;

				$newCatalogue->is_active		= '1';

				$newCatalogue->is_deleted		= '0';

				$newCatalogue->save();



				Session::flash('message', 'Catalogue Create Sucessfully!');

				return redirect()->to('/Catalogue');

			}

		}



		$data['Category']  = Category::where('is_active', '1')->where('is_deleted', '0')->get();

		return view('front.vendor.tailorcatalogue.add_catalogue',$data);



	}



	public function catalogueStatus(Request $request)

	{

		if($request->type=='is_active')

		{

			$result =  DB::table('catalogue')

             ->where('id', $request->id)

             ->update(

                 ['is_active' => $request->status]

             );

			if ($result){

				return response()->json(['success' => true, 'message' => 'Status updated successfully']);

			} else{

				return response()->json(['success' => false, 'message' => 'Failed to update status']);

			}

		}

	}





	public function productStatus(Request $request)

	{

		if($request->type=='availability')

		{

			$result =  DB::table('products')

             ->where('id', $request->id)

             ->update(

                 ['is_available' => $request->status]

             );

			if ($result){

				return response()->json(['success' => true, 'message' => 'Availability updated successfully']);

			} else{

				return response()->json(['success' => false, 'message' => 'Failed to update Availability']);

			}

		}

		if($request->type=='is_active')

		{

			$result =  DB::table('products')

             ->where('id', $request->id)

             ->update(

                 ['is_active' => $request->status]

             );

			if ($result){

				return response()->json(['success' => true, 'message' => 'Status updated successfully']);

			} else{

				return response()->json(['success' => false, 'message' => 'Failed to update status']);

			}

		}

	}

	public function deleteProduct($id){



		$result = DB::table('products')

    		->where('id', $id)

    		->update(['is_deleted' => 1]);



		if ($result > 0) {

			// Successfully updated at least one row

			Session::flash('message', 'Product deleted successfully!');

		} else {

			// No rows updated

			Session::flash('message', 'Failed to delete product or already deleted.');

		}



		return redirect()->to('/vendorProduct');

	}

	public function addProduct(Request $request, $id = null)

	{

		//This function is for add product

		$category           = $request->category_id;

        $product_name       = $request->name;

		$product_image	= $request->product_image;

		$old_product_image = $request->old_product_image;

		$fab_type			= $request->fab_type;

        $galary_img         = $request->galary_img;

		$old_image          = $request->old_image;

        $product_type       = $request->product_type;

        $fabric_type        = $request->fabric_type;

        $gender_type        = $request->gender_type;

        $product_details    = $request->product_detail;

		$price   			= $request->price;

		$discount			= $request->discount;

		$finalPrice			= $request->finalPrice;

		$sizes              = $request->sizes;

		$vendor_id			= auth('vendor')->id();







		$data['product'] = '';

		if($id)

		{

            $data['product'] = Product::where('id', $id)->first();

			$data['productImages'] = ProductImage::where('product_id', $id)->get();

			$data['ProductVariants'] = ProductVariant::where('product_id', $id)->get()->groupBy('size_id');

        }

		if ($request->isMethod('post')) {

			if($request->product_id){



				if($product_image){

					$imageName = uniqid().'.'.$product_image->extension();

					$product_image->move(public_path('Productupload'), $imageName);

				}else{

					$imageName = $old_product_image;

				}



				$productUpdate = Product::where('id', $request->product_id)->first();

				$productUpdate->category_id     = $category;

				$productUpdate->product_name    = $product_name;

				$productUpdate->product_details = $product_details;

				$productUpdate->product_image	= $imageName;

				$productUpdate->product_type    = $product_type;

				$productUpdate->gender_type     = $gender_type;

				$productUpdate->febric_type_id  = $fab_type;

				$productUpdate->product_price	= $price;

				$productUpdate->discount		= $discount;

				$productUpdate->final_price 	= $finalPrice;

				$productUpdate->is_available    = '1';

				$productUpdate->is_available    = '1';

				$productUpdate->is_deleted      = '0';

				$productUpdate->vendor_id 		= $vendor_id;

				$productUpdate->save();



				// //Galary image Update code =========================================================================================



				ProductImage::where('product_id', $request->product_id)->delete();

				if($galary_img){

					foreach($galary_img  as $img){

						$imageName = uniqid().'.'.$img->extension();

						$img->move(public_path('Productupload'), $imageName);

						$newProduct_images                  = new ProductImage();

						$newProduct_images->product_id      = $productUpdate->id;

						$newProduct_images->product_image   = $imageName;

						$newProduct_images->save();

					}

				}else{

					foreach($old_image  as $img){

						$newProduct_images                  = new ProductImage();

						$newProduct_images->product_id      = $productUpdate->id;

						$newProduct_images->product_image   = $img;

						$newProduct_images->save();

					}

				}



				//ProductVariant Update code =========================================================================================



				ProductVariant::where('product_id', $request->product_id)->delete();



				foreach ($request->sizes as $index => $sizeId) {

					$colors = $request->colors[$index] ?? [];

					foreach ($colors as $colorId) {

						$newProductVariant = new ProductVariant();

						$newProductVariant->product_id = $productUpdate->id;

						$newProductVariant->size_id = $sizeId;

						$newProductVariant->colour_id = $colorId;

						$newProductVariant->save();

					}

				}



				Session::flash('message', 'Product Update Sucessfully!');

				return redirect()->to('/vendorProduct');







			}else{



				if($product_image){

					$imageName = uniqid().'.'.$product_image->extension();

					$product_image->move(public_path('Productupload'), $imageName);

				}





				$newProduct                  = new Product();

				$newProduct->category_id     = $category;

				$newProduct->product_name    = $product_name;

				$newProduct->product_details = $product_details;

				$newProduct->product_image	 = $imageName;

				$newProduct->product_type    = $product_type;

				$newProduct->gender_type     = $gender_type;

				$newProduct->febric_type_id  = $fab_type;

				$newProduct->product_price	 = $price;

				$newProduct->discount		 = $discount;

				$newProduct->final_price 	 = $finalPrice;

				$newProduct->is_available    = '1';

				$newProduct->is_available    = '1';

				$newProduct->is_deleted      = '0';

				$newProduct->vendor_id 		 = $vendor_id;

				$newProduct->save();



				// save product==================================================================================================



				foreach($galary_img  as $img){

					$imageName = uniqid().'.'.$img->extension();

					$img->move(public_path('Productupload'), $imageName);

					$newProduct_images                  = new ProductImage();

					$newProduct_images->product_id      = $newProduct->id;

					$newProduct_images->product_image   = $imageName;

					$newProduct_images->save();

				}



				// save product images ==================================================================================================





				foreach ($request->sizes as $index => $sizeId) {

					$colors = $request->colors[$index] ?? [];

					foreach ($colors as $colorId) {

						$newProductVariant = new ProductVariant();

						$newProductVariant->product_id = $newProduct->id;

						$newProductVariant->size_id = $sizeId;

						$newProductVariant->colour_id = $colorId;

						$newProductVariant->save();

					}

				}



				// save product Variant ==================================================================================================



			}





			Session::flash('message', 'Product Create Sucessfully!');

			return redirect()->to('/vendorProduct');



		}











		$data['category'] = DB::table('category')->select('category_id','category_name')->where('is_active',1)->where('is_deleted',0)->get();

		$data['colors'] = DB::table('color_master')->select('color_id','color_name','color_code')->where('is_active',1)->where('is_deleted',0)->get();

		$data['sizes'] = DB::table('size_master')->select('id','size_name')->where('is_active',1)->where('is_deleted',0)->get();

		$data['febricTypes'] = DB::table('febric_type_master')->select('febric_type_id','febric_type_name')->where('is_active',1)->where('is_deleted',0)->get();

		return view('front.vendor.add_product',$data);

	}



	public function finalPrice(Request $request){

		$price = $request->input('price');

		$discount = $request->input('discount');

		$finalPrice = $price - ($price * ($discount / 100));

		return response()->json(['final_price' => round($finalPrice, 2)]);

	}



	public function template(){

		$user_id = auth('user')->id();

		$data['user_id'] =  $user_id;

		$data['allUsers'] = User::where('user_type','1')->get();



		return view('message_delete_it',$data);

	  }


		//delete it start
	  public function vendorMessages_delete_it(){
		$user_id = auth('user')->id();
		$data['user_id'] =  $user_id;
		$data['allUsers'] = User::where('user_type','1')->get();
		return view('front.vendor.message_delete_it',$data);
	  }
	  //delete it end



//added from here to below
public function chatRoomVendor(){

	$user_id = auth('user')->id();

	if(Auth::guard('user')->check()){

	$user = Auth::guard("user")->user();

	$user_id = $user->id;
	$user_name = $user->first_name.' '.$user->last_name;

	$langCode = 'eng';

	if(isset($_GET['meetingId'])){

	$meetingId = $_GET['meetingId'];

	$get_meeting_res = DB::table('bbb_meetings')->where('meeting_id', '=', $meetingId)->where('status', '=', 1)->first();

	}else{

	$get_meeting_res = DB::table('bbb_meetings')->where('user_id', '=', $user_id)->where('status', '=', 1)->first();

	}

	if(!empty($get_meeting_res->user_id)){

	 $meetinginfo_response = $this->getMeetingInfo($get_meeting_res->meeting_id, $get_meeting_res->moderator_pw);

	 if($meetinginfo_response['returncode'][0]=='FAILED'){

	  DB::table('bbb_meetings')->where(['meeting_id' => $get_meeting_res->meeting_id])->update(['status'=>0,'updated_at'=>date('Y-m-d H:i:s')]);

	  if(isset($_GET['meetingId'])){

	  return redirect()->to('/vendorsDasboard');

	  }

	 }

	 }


	if(empty($get_meeting_res->user_id) || $meetinginfo_response['returncode'][0]=='FAILED'){

		$rand = substr(str_shuffle('0123456789'), 1, 4);

		$meeting_id = $rand . $user_id;

		$meeting_name = $user_name.' Meeting';
		$attendee_pw = 'ap' . $rand . $user_id;
		$moderator_pw = 'mp' . $rand . $user_id;


	$create_meeting_res = $this->createMeeting($meeting_id, $meeting_name, $attendee_pw, $moderator_pw, $user_id);

	$userId = $user->id;

	$user_name = $user->first_name. ' ' .$user->last_name;

	$moderator_res = $this->moderatorUrl($meeting_id, $user_name, $moderator_pw, $userId);

	if($moderator_res['code'] == 1) {

	$bbb_url = $moderator_res['msg'];

		$meeting_arr = array(
			'user_id' => $user_id,
			'meeting_id' => $meeting_id,
			'meeting_name' => $meeting_name,
			'meeting_url' => $bbb_url,
			'attendee_pw' => $attendee_pw,
			'moderator_pw' => $moderator_pw,
			'is_create' => 0,
			'status' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

	$insert_meeting_res = DB::table('bbb_meetings')->insert($meeting_arr);


	$data['start_url'] = $bbb_url;

	$data['user_id'] =  $user_id;

	$data['meeting_id'] =  $meeting_id;

	$data['allCustomers'] = User::where('user_type','1')->get();

	return view('front.vendor.video',$data);

		//return json_encode(array('status' => 'success', 'url' => $bbb_url));

	} else {

		return json_encode(array('status' => 'error'));

	}

}else{


$user_id = $get_meeting_res->user_id;
$meeting_id = $get_meeting_res->meeting_id;
$meeting_name = $get_meeting_res->meeting_name;
$moderator_pw = $get_meeting_res->moderator_pw;
$meeting_url = $get_meeting_res->meeting_url;

	$bbb_url = $meeting_url;

	$data['start_url'] = $bbb_url;

	$data['user_id'] =  $user_id;

	$data['meeting_id'] =  $meeting_id;

	$data['allCustomers'] = User::where('user_type','1')->get();

	return view('front.vendor.video',$data);

}

  }else{

	return redirect()->to('/login');

 }


}


public function get_recording($meeting_id) {
	$bbb = new BigBlueButton();
	$recordingParams = array('meetingId' => $meeting_id);

	$resp = $bbb->getRecordingsWithXmlResponseArray($recordingParams);

	if ($resp['returncode'] == 'SUCCESS' || $resp['returncode'] == 'success') {
		$video_url = @$resp[0]['playbackFormatUrl'];
	} else {
		$video_url = '';
	}
	return $video_url;
}

	public function getMeetingInfo($meeting_id, $mp_password) {
	// Instatiate the BBB class:
	$bbb = new BigBlueButton();

	/* ___________ GET MEETING INFO ______ */
	/* Get meeting info based on meeting id.
	 */

	$infoParams = array(
		'meetingId' => $meeting_id, // REQUIRED - We have to know which meeting.
		'password' => $mp_password, // REQUIRED - Must match moderator pass for meeting.
	);

	// Now get meeting info and display it:
	$itsAllGood = true;
	try {
		$result = $bbb->getMeetingInfoWithXmlResponseArray($infoParams);
	} catch (Exception $e) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
		$itsAllGood = false;
	}

	if ($itsAllGood == true) {
		// If it's all good, then we've interfaced with our BBB php api OK:
		/* if ($result == null) {
		  // If we get a null response, then we're not getting any XML back from BBB.
		  echo "Failed to get any response. Maybe we can't contact the BBB server.";
		  }
		  else {
		  // We got an XML response, so let's see what it says:
		  //var_dump($result);

		  if (!isset($result['messageKey'])) {
		  // Then do stuff ...
		  echo "<p>Meeting info was found on the server.</p>";
		  }
		  else {
		  echo "<p>Failed to get meeting info.</p>";
		  }
		  } */
		return $result;
	}
}

public function createMeeting($meeting_id, $meeting_name, $attendee_pw, $moderator_pw, $user_id) {

	$logoutUrl = url('/') . '/bbb_redirect/' . $user_id;

	// Instatiate the BBB class:
	$bbb = new BigBlueButton();

	/* ___________ CREATE MEETING w/ OPTIONS ______ */
	/*
	 */
	$creationParams = array(
		'meetingId' => $meeting_id,
		'meetingName' => $meeting_name,
		'attendeePw' => $attendee_pw,
		'moderatorPw' => $moderator_pw,
		'welcomeMsg' => '',
		'dialNumber' => '',
		'voiceBridge' => '',
		'webVoice' => '',
		'logoutUrl' => $logoutUrl,
		'maxParticipants' => '-1',
		'record' => 'true',
		'duration' => '0',
	);

	// Use print_r to display the array

	$itsAllGood = true;
	try {
		$result = $bbb->createMeetingWithXmlResponseArray($creationParams);
	} catch (Exception $e) {
		//echo 'Caught exception: ', $e->getMessage(), "\n";
		$itsAllGood = false;

		$return['code'] = 2;
		$return['msg'] = 'Caught exception: ' . $e->getMessage() . "\n";
	}

	$return = array();
	if ($itsAllGood == true) {
		// If it's all good, then we've interfaced with our BBB php api OK:
		if ($result == null) {
			// If we get a null response, then we're not getting any XML back from BBB.
			/* echo "Failed to get any response. Maybe we can't contact the BBB server."; */
			$return['code'] = 2;
			$return['msg'] = "Failed to get any response. Maybe we can't contact the BBB server.";
		} else {
			// We got an XML response, so let's see what it says:
			//echo "<pre>";
			//print_r($result);
			if ($result['returncode'] == 'SUCCESS') {
				// Then do stuff ...
				/* echo "<p>Meeting succesfullly created.</p>"; */
				$return['code'] = 1;
				$return['msg'] = "<p>Meeting succesfullly created.</p>";
			} else {
				/* echo "<p>Meeting creation failed.</p>"; */
				$return['code'] = 2;
				$return['msg'] = "<p>Meeting creation failed.</p>";
			}
		}
	}

	return $return;

}

public function moderatorUrl($meeting_id, $user_name, $moderator_pw, $userId = '') {
	// Instatiate the BBB class:
	$bbb = new BigBlueButton();

	/* ___________ JOIN MEETING w/ OPTIONS ______ */
	/* Determine the meeting to join via meetingId and join it.
	 */

	$joinParams = array(
		'meetingId' => $meeting_id, // REQUIRED - We have to know which meeting to join.
		'username' => $user_name, // REQUIRED - The user display name that will show in the BBB meeting.
		'password' => $moderator_pw, // REQUIRED - Must match either attendee or moderator pass for meeting.
		'createTime' => '', // OPTIONAL - string
		'userId' => $userId, // OPTIONAL - string
		'webVoiceConf' => ''          // OPTIONAL - string
	);

	// Get the URL to join meeting:
	$itsAllGood = true;
	try {
		$result = $bbb->getJoinMeetingURL($joinParams);
	} catch (Exception $e) {
		//echo 'Caught exception: ', $e->getMessage(), "\n";
		$itsAllGood = false;
		$return['code'] = 2;
		$return['msg'] = 'Caught exception: ' . $e->getMessage() . "\n";
	}

	if ($itsAllGood == true) {
		//Output results to see what we're getting:
		//print_r($result);
		$return['code'] = 1;
		$return['msg'] = $result;
	}
	return $return;
}






public function vendorMessageSubmit(Request $request){

	$data['customer'] = User::where('id', auth('user')->id())->first();

	$data['merchent'] = User::where('id', $request->reciver_id)->first();



	$user = $data['customer'];

	$merchent = $data['merchent'];

	$my_msg = $request->my_msg;



	$sender_id = $request->sender_id;

	$reciver_id =(int) $request->reciver_id;

	$userTimeZone  = $request->userTimeZone;

	$update_message_id = $request->input('update_message_id');

	$reply_message_id = $request->input('reply_message_id');







	$currentDateTime = Carbon::now($userTimeZone)->format('Y-m-d H:i:s');





	$newChat = new ChatMessage();

	$newChat->sender_id = $sender_id;

	$newChat->msg		= $my_msg;

	$newChat->status	= '1';

	$newChat->created_at = $currentDateTime;

	$newChat->save();

	$newChat_id = $newChat->id;



	$newChatStatus = new ChatStatus();

	$newChatStatus->receiver_id = $reciver_id;

	$newChatStatus->chat_msg_id = $newChat_id;

	$newChatStatus->is_read = 0;

	$newChatStatus->status = 0;

	$newChatStatus->chat_msg_type = 1;

	$newChatStatus->created_at = $currentDateTime;

	$newChatStatus->save();

	$newChatStatus_id = $newChatStatus->id;



	$imageName = '';



	if($request->hasFile('photo')){

		$image = $request->file('photo');

		$imageName = "cus".time().'.'.$image->extension();

		$image->move(public_path('/uploads/chat'), $imageName);



		$newChatSharedFile = new ChatSharedFile();

		$newChatSharedFile->chat_id   = $newChat_id;

		$newChatSharedFile->file_name = $imageName;

		$newChatSharedFile->file_type = $request->file_type;

		$newChatSharedFile->is_active_file = '1';

		$newChatSharedFile->save();

	}



	$time = Carbon::now($userTimeZone)->format('h:i A');



	$data = [

		'msg_id' => $newChat_id,

		'msg' =>$my_msg,

		'sender_id' =>$sender_id,

		'profile_image' => $data['customer']->profile_image,

		'name' => $data['customer']->first_name,

		'time' => $time,

		'msg_image' => $imageName,

	];



	event(new MessageSent($data));





	$userChat = DB::table('chat_msg as c')

	->select('c.id as chat_id', 'c.sender_id', 'c.msg','c.created_at','c.is_share_file', 'c.is_link','c.is_meet_in_classroom','c.file_type','c.mime_type','c.is_reply','c.reply_message_id','c.reply_share_message_id','c.is_forward','c.track_duration','users.id','users.profile_image','users.first_name as sender_name','chat_shared_file.file_name')

	->Join('users', 'users.id', '=', 'c.sender_id')

	->leftJoin('chat_shared_file', 'chat_shared_file.chat_id', '=', 'c.id')

	->Join('chat_msg_status', 'chat_msg_status.chat_msg_id', '=' , 'c.id')

	->where('chat_msg_status.receiver_id', '=', $reciver_id)

	->orderBy('chat_id', 'DESC')

	->first();





	$html = '<div class="d-flex justify-content-end mb-4 side-right-chat" id="' . $newChat_id . '">

			<div class="msg_cotainer_send">';



	if (!empty($userChat)) {



		if($userChat->file_name){

			$html .= '<div class="drop-msg-send"><img src="' . (empty($userChat->file_name) ?  'please select image!' : url('/public/uploads/chat/' . $userChat->file_name)) . '" alt="Sender Avatar" class="image_fluid">' . '</div><span class="msg_time_send">' . \Carbon\Carbon::parse($userChat->created_at)->format('h:i A') . '</span>';

		}else{

			$html .= '<div class="drop-msg-send">' . $userChat->msg . '</div><span class="msg_time_send">' . \Carbon\Carbon::parse($userChat->created_at)->format('h:i A') . '</span>';

		}



	}



	$html .= '

		</div>

		<div class="img_cont_msg">

			<img src="' . (empty($user->profile_image) ? url('/public').'/front_assets/images/reviw1.png' : url('/public/admin/uploads/user/' . $user->profile_image)) . '" alt="Sender Avatar" class="rounded-circle user_img">

		</div>

	</div>';



	return response()->json([

		'status' => 'success',

		'html' => $html

	]);


}

//added from here to below



}

