<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Libraries\BigBlueButton;
use App\Models\UserSubjects;
use App\Models\ChatMessage;
use App\Models\UserLanguages;
use App\Libraries\ZoomAPI;
use App\Models\UserLanguage;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Review;
use App\Models\DocumentProd;
use App\Models\UserVerify;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Session;
use Validator;
use DB;
use Hash;
use Mail;

class HomeController extends Controller
{
	public function AllGuruer()
	{
		$data['allUsersSubject'] = UserSubjects::where('is_active','1')->where('is_deleted','0')->get();
		$data['allUsersLanguage'] = UserLanguages::get();
		$data['allUsersName'] = User::where('user_type','2')->where('is_deleted','0')->get();

		$data['allUsers'] = User::where('users.user_type', '2') // Specify the table for 'user_type'
								->where('users.is_deleted', '0') // Specify the table for 'is_deleted'
								->leftJoin('reviews', 'reviews.vendor_id', '=', 'users.id')
								->leftJoin('user_languages', 'users.id', '=', 'user_languages.user_id') // LEFT JOIN user_languages
								->leftJoin('master_language', 'master_language.language_id', '=', 'user_languages.language_id') // LEFT JOIN master_language
								->leftJoin('guruer_subjects', 'users.id', '=', 'guruer_subjects.user_id') // LEFT JOIN guruer_subjects
								->leftJoin('subjects', 'subjects.id', '=', 'guruer_subjects.subject_id') // LEFT JOIN subjects
								->select(
										'users.id as id',
										'users.first_name',
										'users.last_name',
										'users.email_id',
										'users.mobile_number',
										'users.price',
										'users.online_status',
										'users.address',
										'users.country_id',
										'users.state_id',
										'users.city_id',
										'users.zipcode',
										'users.profile_image',
										'users.video_type',
										'users.video_data',
										DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating'),
										DB::raw('GROUP_CONCAT(DISTINCT master_language.language_name ORDER BY master_language.language_name) as languages'), 
										DB::raw('GROUP_CONCAT(DISTINCT subjects.subject_name ORDER BY subjects.subject_name) as subjects') 
									)
								->groupBy(
									'users.id',
									'users.first_name',
									'users.last_name',
									'users.email_id',
									'users.mobile_number',
									'users.price',
									'users.online_status',
									'users.country_id',
									'users.state_id',
									'users.city_id',
									'users.zipcode',
									'users.address',
									'users.profile_image',
									'users.video_type',
									'users.video_data',
								) 
								->get();
		return view("front/all_guruer",$data);
	}
	public function login()
	{
		//This function is for login
		// Redirect to the user dashboard if authenticated
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
			$user = Auth::guard("user")->user();
			$user->online_status = '1';
			$user->save();
			if($user->user_type == '1')
			{
				return redirect()->to('/customerDashboard');
			}else{
				return redirect()->to('/vendorsDasboard');
			}
		}

		else {
			// Flash a message and redirect back on failure
			return back()->with('error','Email  id & Password is incorrect');
		}

	}
	public function loginchk_ajax(Request $request)
	{
		 // Validate the request
		 $request->validate([
			"email" => "required|email",
			"password" => "required"
		]);

		// Attempt login
		if (Auth::guard("user")->attempt([
			"email_id" => $request->email,
			"password" => $request->password
		])) {
			$user = Auth::guard("user")->user();
			$user->online_status = '1';
			$user->save();

			//$redirectUrl = $user->user_type == '1' ? '/guruer' : '/guruer';
			$redirectUrl = $request->current_url;

			// Check if it's an AJAX request
			if ($request->ajax()) {
				return response()->json([
					'success' => true,
					'message' => 'Login successful!',
					'redirect_url' => $redirectUrl
				]);
			}

			// Standard form submission redirect
			return redirect()->to($redirectUrl);
		} else {
			// Handle invalid credentials
			$errorMessage = 'Email ID & Password is incorrect';

			// Check if it's an AJAX request
			if ($request->ajax()) {
				return response()->json([
					'success' => false,
					'message' => $errorMessage
				]);
			}

			// Standard form submission redirect
			return back()->with('error', $errorMessage);
		}

	}

	public function getAllChats_byUser()
    {
    	$user = Auth::guard("user")->user();

		if (!$user) {
			return collect(); // Return an empty collection if not logged in
		}
		$userId = $user->id;
		
		return ChatMessage::join('users', 'chat_msg.sender_id', '=', 'users.id') // Join the users table
		->join('chat_msg_status', 'chat_msg.id', '=', 'chat_msg_status.chat_msg_id') // Join the chat_msg_status table
		->where('chat_msg_status.receiver_id', $userId) // Filter based on receiver_id
		->where('chat_msg_status.status', '0') // Filter for active status in chat_msg_status
		->orderBy('chat_msg.id', 'desc') // Order by message ID in descending order
		->select('chat_msg.*', 'users.profile_image', 'users.online_status', 'chat_msg_status.is_read') // Select necessary columns
		->get();
    }


	public function getAllFav_wishlist()
    {
    	$user = Auth::guard("user")->user();
		if (!$user) {
			return collect();
		}
		$userFollowers = $user->user_followers;
		if (!$userFollowers) {
			return collect();
		}
		$followerIds = explode(',', $userFollowers);
		return User::whereIn('id', $followerIds)
					->orderBy('id', 'desc')
					->get();
    }

	public function getUpdatedWishlist()
	{
		$user = Auth::guard("user")->user();
		if (!$user) {
			return response()->json(['success' => false, 'wishlist' => []]);
		}

		$userFollowers = $user->user_followers;
		if (!$userFollowers) {
			return response()->json(['success' => false, 'wishlist' => []]);
		}

		$followerIds = explode(',', $userFollowers);

		$wishlist = User::whereIn('id', $followerIds)
						->orderBy('id', 'desc')
						->get()
						->map(function ($item) {
							$item->profile_image = file_exists(public_path('admin/uploads/user/' . $item->profile_image)) && $item->profile_image
								? url('public/admin/uploads/user/' . $item->profile_image)
								: url('public/front_assets/images/default-img.jpg');
							return $item;
						});

		return response()->json(['success' => true, 'wishlist' => $wishlist]);
	}

	public function favorites_users_ajax(Request $request)
	{
		$sender_user_id = $request->sender;
		$user_id = $request->user;

		helper_update_follower_wish($sender_user_id,$user_id);
	}

	public function register()
	{
		//This is for new registeration
		if (Auth::guard('user')->check()) {
			// Redirect to the user dashboard if authenticated
			return redirect()->to('/customerDashboard');
		}
		return view("register");
	}

	public function showLinkRequestForm()
	{
		if (Auth::guard('user')->check()) {
			return redirect()->to('/customerDashboard');
		}
		return view("forgetpassword");
	}

	public function broker()
	{
		return Password::broker('users'); // Ensure the 'users' broker is correctly configured in config/auth.php
	}

	public function sendResetLinkEmail(Request $request)
	{
		// Validate the email address
		$request->validate([
			'email_id' => 'required|email|exists:users,email_id', // Ensure the email exists in the users table
		],[
			'email_id.exists' => 'The email ID does not exist in our database',
		]);

		// Manually map 'email_id' to 'email' for Laravel to process the reset request
		$email_id = $request->input('email_id');

		// Attempt to send the password reset link
		$response = Password::broker('users')->sendResetLink(
			['email' => $email_id] // Pass 'email' to the broker instead of 'email_id'
		);

		// Handle the response
		if ($response == Password::RESET_LINK_SENT) {
			/*
			return response()->json([
				'message' => trans($response)
			], 200);
			*/
			//return redirect()->back();
			return redirect()->back()->with('status', trans($response));

		} else {
			return response()->json([
				'error' => trans($response)
			], 422);
		}
	}


	public function showResetForm(Request $request)
	{
		$token = $request->route('token');
		$email = $request->input('email');
		return view('resetpassword', compact('token', 'email'));
	}

	public function resetPassword(Request $request)
	{
		// Validate the request data
		$request->validate([
			'email' => 'required|email',
			'password' => 'required|string|min:8|confirmed',
			'token' => 'required|string',
		]);

		// Use Laravel's password broker to check the token
		$response = Password::broker()->reset(
			[
				'email' => $request->email,
				'token' => $request->token,
				'password' => $request->password,
			],
			function ($user) use ($request) {
				$user->password = Hash::make($request->password);
				$user->save();
			}
		);

		// If the token is invalid or expired, return an error message
		if ($response == Password::INVALID_TOKEN) {
			return back()->withErrors(['token' => 'Invalid or expired token.']);
		}

		// If the reset was successful, redirect to the login page with a success message

		return redirect()->back()->with('status', 'Password has been reset successfully!');
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
			$user->last_name = trim($request->last_name);
			$user->email_id = $request->email_id;
			$user->email = $request->email_id;
			$user->mobile_number = $request->number_field;
			$user->password = Hash::make($request->password);
			$user->user_status = "1";
			$user->customer_type = "0";
			$user->user_type	 = $request->user_type;
			$user->is_social= "0";
			$user->is_deleted= "0";
			$user->save();
			$user_id = $user->id;
			$token = Str::random(64);

			UserVerify::create([
				'user_id' => $user_id,
				'token' => $token
			  ]);
			
			Mail::send('emailVerificationEmail', ['token' => $token], function($message) use($request){
				$message->to($request->email_id);
				$message->subject('Email Verification Mail');
			});
			Session::flash('message', 'User Register Sucessfully!');
			return redirect()->to('/login');
		}
	}

	public function zoom_meeting(Request $request)
	{
		$user_email = 'votivedeepak.php@gmail.com';
		$first_name = 'deepak';
		$last_name = 'sahu';
		
		$userDetails= array('email'=>$user_email,
							'first_name'=>$first_name,
							'last_name'=>$last_name
							);

		$schedule_stime = '2024-12-12 17:00:00';
		$schedule_etime = '2024-12-12 19:00:00';
		$startTime = strtotime($schedule_stime);
		$endTime = strtotime($schedule_etime);
		$mins = ($endTime - $startTime) / 60;
		$lesson_id = '111';
		$tutor_email = 'amit@gmail.com';

		$meetingParam = array(
							'lesson_id' => $lesson_id,
							'email' => $tutor_email,
							'topic' => 'Zoom Meeting',
							'start_time' =>$startTime,
							'timezone' =>'',
							'duration' =>$mins,
							'agenda' => 'Zoom Meeting',
						);

		$zoom_user_id='';
		$Zoomobj =  new ZoomAPI();
		$checkZoomUser = $Zoomobj->getUser($userDetails);

		if(empty($checkZoomUser['id']))
		{
			$zoomUser = $Zoomobj->createUser($userDetails);
			$zoom_user_id = $zoomUser['id'];
		}
		else
		{
			$zoom_user_id = $checkZoomUser['id'];
		}

		$meetingParam['zoom_user_id']= $zoom_user_id;
		$meetingContent = $Zoomobj->createZoomMeeting($meetingParam);

		if(!empty($meetingContent['id']))
		{
			$meeting_arr = array(
							'lesson_id' => $lesson_id,
							'meeting_id' => $meetingContent['id'],
							'meeting_name' => 'Zoom Meeting',
							'start_url' => $meetingContent['start_url'],
							'join_url' => $meetingContent['join_url'],
							'attendee_pw' => '',
							'moderator_pw' => '',
							'is_create' => 1,
							'status' => 1,
							'created_at' => date('Y-m-d H:i:s')
						);

			$start_url = $meetingContent['start_url'];
			$join_url = $meetingContent['join_url']; // first meeting end then start new meeting
			?>
			<script type="text/javascript">

				window.location = "<?php echo $start_url;?>"

			</script>';
			<?php
		}
	}

	public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
		$user = User::where('id',$verifyUser->user_id)->first();
        $message = 'Sorry your email cannot be identified.';

		if(!is_null($verifyUser) )
		{
            if(!$user->is_email_verified == '1') 
			{
                $user->is_email_verified = '1';
                $user->save();
                $message = "Your e-mail is verified. You can now login.";
            } 
			else 
			{
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
      return redirect('login')->with('message', $message);
    }

	public function logout(Request $request)
    {
        // Log out the authenticated user
		$user = Auth::guard("user")->user();
		$user->online_status = '0';
		$user->save();
        Auth::guard('web')->logout();
		Auth::guard('user')->logout();
		Auth::guard('vendor')->logout();
        // Clear all session data
        Session::flush();
        // Redirect to login or home page
        return redirect('/login')->with('status', 'You have been logged out successfully.');
    }

	/*********************Master Pages**************************/
	public function dt()
	{
		$data['allUsers'] = User::where('is_deleted','0')->get();
		return view("front/browse_febric",$data);
	}

	public function guruerDetail($id)
	{
		$data['review_data'] = Review::select('users.profile_image', 'users.first_name', 'users.last_name', 'rating', 'review_text', 'reviews.created_at')->where('vendor_id',$id)->join('users','users.id','=','reviews.user_id')->orderBy('reviews.id','desc')->get();
		$avg_review = Review::where('vendor_id',$id)->join('users','users.id','=','reviews.user_id')->avg('rating');
		$data['rating_avg'] = round($avg_review,0);

		// Total number of reviews for the vendor
		$totalReviews = Review::where('vendor_id', $id)->count();

		// Group reviews by rating and count each group
		$ratingsDistribution = Review::where('vendor_id', $id)
										->select(DB::raw('FLOOR(rating) as rating'), DB::raw('COUNT(*) as count')) // Use FLOOR to ensure ratings are integers
										->groupBy('rating')
										->pluck('count', 'rating')
										->toArray();

		// Calculate percentages for 5-star to 1-star
		$starPercentages = [];
		for ($i = 5; $i >= 1; $i--) {
			$countForRating = $ratingsDistribution[$i] ?? 0; // Default to 0 if rating is not present
			$starPercentages[$i] = $totalReviews > 0
				? round(($countForRating / $totalReviews) * 100, 2)
				: 0;
		}

        $data['star_rating_show'] = $starPercentages;

		$data['guruer_for_slider'] = User::where('users.user_type', '2')
											->where('users.is_deleted', '0')
											->leftJoin('reviews', 'reviews.vendor_id', '=', 'users.id')
											->select(
												'users.id',
												'users.first_name',
												'users.last_name',
												'users.profile_image',
												DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating')
											)
											->groupBy(
												'users.id',
												'users.first_name',
												'users.last_name',
												'users.profile_image'
											)
											->get();

		$data['guruer'] = User::where('users.user_type', '2')
								->where('users.id', $id)
								->where('users.is_deleted', '0')
								->leftJoin('user_languages', 'users.id', '=', 'user_languages.user_id')
								->leftJoin('master_language', 'master_language.language_id', '=', 'user_languages.language_id')
								->leftJoin('guruer_subjects', 'users.id', '=', 'guruer_subjects.user_id')
								->leftJoin('subjects', 'subjects.id', '=', 'guruer_subjects.subject_id')
								->select(
									'users.id as id',
									'users.first_name',
									'users.last_name',
									'users.email_id',
									'users.mobile_number',
									'users.price',
									'users.online_status',
									'users.address',
									'users.country_id',
									'users.state_id',
									'users.city_id',
									'users.zipcode',
									'users.profile_image',
									'user_status',
									'users.video_type',
									'users.video_data',
									DB::raw('GROUP_CONCAT(DISTINCT master_language.language_name ORDER BY master_language.language_name) as languages'), // Use DISTINCT to remove duplicates
									DB::raw('GROUP_CONCAT(DISTINCT subjects.subject_name ORDER BY subjects.subject_name) as subjects') // Use DISTINCT to remove duplicates
									)
								->groupBy(
								'users.id',
								'users.first_name',
								'users.last_name',
								'users.email_id',
								'users.mobile_number',
								'users.price',
								'users.online_status',
								'users.country_id',
								'users.state_id',
								'users.city_id',
								'users.zipcode',
								'users.address',
								'users.profile_image',
								'user_status',
								'users.video_type',
								'users.video_data',
								)
								->first();

		return view("front/guruer_detail",$data);

	}

	public function store(Request $request)
    {
		$validator=Validator::make($request->all(),[
			'rating3' => 'required|integer|min:1|max:5',
			'comment' => 'required'
        ]);


		if ($validator->fails()) {
            return response()->json(["ok" => 0,"message" => "Please write your review"]);
        }

		try {
		   $user_review_exist = Review::where('user_id', $request->user_id)->where('vendor_id', $request->vendor_id)->count();

			if($user_review_exist == 0)
			{
				$review = new Review();
				$review->user_id =  $request->input('user_id');
				$review->review_text = $request->input('comment');
				$review->rating = $request->input('rating3');
				$review->vendor_id = $request->input('vendor_id');
				$review->status = "1";
				$review->save();

				return response()->json([
					'ok' => true,
					'message' => 'Your review has been submitted successfully!'
				]);
		 	}
			else
			{
				return response()->json(["ok" => 0,"message" => "Rating and review already given."]);
		 	}
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Failed to submit the review. Please try again.'
            ]);
        }
    }

	public function allwishlist()
	{
		$user = Auth::guard("user")->user();
		if (!$user) {
			return redirect()->route('login')->with('error', 'Please login to access your wishlist.');
		}

		$userFollowers = $user->user_followers;
		if (!$userFollowers) {
			$data['wishlist'] = collect(); // Empty collection if no followers are found
		} else {
			$followerIds = explode(',', $userFollowers);
			$data['wishlist'] = User::whereIn('id', $followerIds)
				->orderBy('id', 'desc')
				->get();
		}
		return view("front.all_wishlist", $data);
	}

	public function filterGuruer(Request $request)
	{
		$searchName = $request->input('name');
		$searchSubject = $request->input('subject');

		$data['allUsersSubject'] = UserSubjects::where('is_active','1')->where('is_deleted','0')->get();
		$data['allUsersName'] = User::where('user_type','2')->where('is_deleted','0')->get();
		$data['allUsers'] = DB::table('guruer_subjects')
								->join('users', 'users.id', '=', 'guruer_subjects.user_id')
								->join('subjects', 'subjects.id', '=', 'guruer_subjects.subject_id')
								->select('users.id', 'users.first_name', 'users.last_name', 'users.email_id', 'users.address','users.profile_image')
								->where('users.user_type', '2')  // Ensure the user is of type '2'
								->where('users.is_deleted', '0')  // Ensure the user is not deleted
								->when($searchName, function ($query, $searchName) {
									if (!empty($searchName)) {
										return $query->where('users.id', $searchName);  // Filter by user ID
									}
								})
								->when($searchSubject, function ($query, $searchSubject) {
									if (!empty($searchSubject)) {
										return $query->where('subjects.id', $searchSubject);  // Filter by subject name
									}
								})->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email_id','users.address','users.profile_image')
								->get();

		$data['userLanguages'] = DB::table('user_languages')
									->join('users', 'users.id', '=', 'user_languages.user_id')
									->join('master_language', 'master_language.language_id', '=', 'user_languages.language_id')
									->select('master_language.language_name','user_languages.user_id')
									->get();

		$data['userSubject']  = DB::table('guruer_subjects')
									->join('users', 'users.id', '=', 'guruer_subjects.user_id')
									->join('subjects', 'subjects.id', '=', 'guruer_subjects.subject_id')
									->select('subjects.subject_name','guruer_subjects.user_id')
									->get();
		return view("partials.guru_results",$data);
	}

	public function loadResults(Request $request)
	{
		$searchName = $request->input('name');
		$searchSubject = $request->input('subject');
		$searchLanguage = $request->input('language');
		$sortPrice = $request->input('price');
		$searchKeyword = $request->input('keyword');
		$betweenStartPrice = $request->input('startprice');
		$betweenEndPrice = $request->input('endprice');

		$data['allUsersSubject'] = UserSubjects::where('is_active','1')->where('is_deleted','0')->get();
		$data['allUsersLanguage'] = UserLanguages::get();
		$data['allUsersName'] = User::where('user_type','2')->where('is_deleted','0')->get();
		$data['allUsers'] = DB::table('users')
								->leftJoin('user_languages', 'users.id', '=', 'user_languages.user_id') // LEFT JOIN user_languages
								->leftJoin('master_language', 'master_language.language_id', '=', 'user_languages.language_id') // LEFT JOIN master_language
								->leftJoin('guruer_subjects', 'users.id', '=', 'guruer_subjects.user_id') // LEFT JOIN guruer_subjects
								->leftJoin('subjects', 'subjects.id', '=', 'guruer_subjects.subject_id') // LEFT JOIN subjects
								->select(
									'users.id as id',
									'users.first_name',
									'users.last_name',
									'users.email_id',
									'users.mobile_number',
									'users.price',
									'users.online_status',
									'users.address',
									'users.country_id',
									'users.state_id',
									'users.city_id',
									'users.zipcode',
									'users.profile_image',
									'users.video_type',
									'users.video_data',
									DB::raw('GROUP_CONCAT(DISTINCT master_language.language_name ORDER BY master_language.language_name) as languages'), // Concatenate languages
									DB::raw('GROUP_CONCAT(DISTINCT subjects.subject_name ORDER BY subjects.subject_name) as subjects') // Concatenate subjects
								)
								->where('users.user_type', '2')  // Ensure the user is of type '2'
								->where('users.is_deleted', '0')  // Ensure the user is not deleted
								->when($searchName, function ($query, $searchName) {
									if (!empty($searchName)) {
										return $query->where('users.id', '=', $searchName); // Filter by user ID
									}
								})
								->when($searchSubject, function ($query, $searchSubject) {
									if (!empty($searchSubject)) {
										return $query->whereExists(function ($subQuery) use ($searchSubject) {
											$subQuery->select(DB::raw(1))
												->from('guruer_subjects')
												->whereColumn('guruer_subjects.user_id', 'users.id')
												->where('guruer_subjects.subject_id', '=', $searchSubject);
										}); // Filter users who have the searched subject without restricting the aggregation
									}
								})
								->when($searchLanguage, function ($query, $searchLanguage) {
									if (!empty($searchLanguage)) {
										return $query->whereExists(function ($subQuery) use ($searchLanguage) {
											$subQuery->select(DB::raw(1))
												->from('user_languages')
												->whereColumn('user_languages.user_id', 'users.id')
												->where('user_languages.language_id', '=', $searchLanguage);
										}); // Filter users who have the searched language without restricting the aggregation
									}
								})
								->when($searchKeyword, function ($query, $searchKeyword) {
									$searchKeyword = trim($searchKeyword); // Remove leading and trailing whitespaces
									if (strlen($searchKeyword) > 0) { // Check if searchKeyword has at least one character
										return $query->where(function ($q) use ($searchKeyword) {
											$q->where('users.first_name', 'LIKE', "{$searchKeyword}%")
											->orWhere('users.last_name', 'LIKE', "{$searchKeyword}%")
											->orWhere('users.address', 'LIKE', "%{$searchKeyword}%");
										}); // Filter users by keyword in first_name, last_name, or address
									}
								})
								->when(!is_null($betweenStartPrice) && !is_null($betweenEndPrice), function ($query) use ($betweenStartPrice, $betweenEndPrice) {
									return $query->whereBetween('users.price', [$betweenStartPrice, $betweenEndPrice]);
								})
								->when(!is_null($betweenStartPrice) && is_null($betweenEndPrice), function ($query) use ($betweenStartPrice) {
									return $query->where('users.price', '>=', $betweenStartPrice);
								})
								->when(is_null($betweenStartPrice) && !is_null($betweenEndPrice), function ($query) use ($betweenEndPrice) {
									return $query->where('users.price', '<=', $betweenEndPrice);
								})
								->when($sortPrice, function ($query, $sortPrice) {
									if ($sortPrice == 1) {
										return $query->orderBy('users.price', 'desc'); // Highest price on top
									} else {
										return $query->orderBy('users.price', 'asc'); // Lowest price on top
									}
								})
								->groupBy(
									'users.id',
									'users.first_name',
									'users.last_name',
									'users.email_id',
									'users.mobile_number',
									'users.price',
									'users.online_status',
									'users.address',
									'users.country_id',
									'users.state_id',
									'users.city_id',
									'users.zipcode',
									'users.profile_image',
									'users.video_type',
									'users.video_data',
								)
								->get();
		return view('front/guru_results', $data);
	}

	public function loadvideoResults_ajax(Request $request)
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

		if($user->user_type == 2)
		return view('front.vendor.video_ajax', $data);
		if($user->user_type == 1)
		return view('front.user.video_ajax', $data);

	}


	public function productList(Request $request)
	{
		return view("front/product_list");
	}

	public function vendorDash()
	{
		return view("front/vendor/vendor_dash");
	}

	// BigBlueButton code start

	public function meetInClassroom(Request $request) {
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;

        $message = json_decode($request->msg_info);
        $request->msg_date;
        $request->msg_time;
        $grpid = $request->grpid;
        $group_id = $message->group->group_id;
        $group_name = $message->group->group_name;

        $sender_id = $message->sender->sender_id;
        $sender_name = $message->sender->sender_name;
        $sender_pic = $message->sender->sender_pic;

        $group_id = $_POST['group_id'];

        $rand = substr(str_shuffle('0123456789'), 1, 4);
        $meeting_id = $rand . $group_id;
        $meeting_name = 'Meet in classroom';
        $attendee_pw = 'ap' . $rand . $group_id;
        $moderator_pw = 'mp' . $rand . $group_id;

        $meeting_arr = array(
            'group_id' => $group_id,
            'meeting_id' => $meeting_id,
            'meeting_name' => $meeting_name,
            'attendee_pw' => $attendee_pw,
            'moderator_pw' => $moderator_pw,
            'is_create' => 0,
            'status' => 1,
           // 'is_meet_in_classroom' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $create_meeting_res = $this->createMeeting($meeting_id, $meeting_name, $attendee_pw, $moderator_pw, $group_id);
        if ($create_meeting_res['code'] == 1) {

            $moderator_res = $this->moderatorUrl($meeting_id, $user_name, $moderator_pw, $user_id);
            if ($moderator_res['code'] == 1) {
                $bbb_url = $moderator_res['msg'];
                $bbb_url = trim($bbb_url);
                $studentName = "";
                $studentID = "";
                if (!empty($message->members)) {
                    $receiver = array();
                    foreach ($message->members as $uid => $uinfo) {
                        $studetnInfo = DB::table('users')->select(DB::raw('CONCAT(users.first_name," ", users.last_name) AS student_name'), DB::raw('group_concat(users.id) AS student_id'))->where('id', '=', $uinfo->receiver_id)->first();
                        $studentName .= $studetnInfo->student_name . ",";
                        $studentID .= $studetnInfo->student_id . ",";
                        $studentName = rtrim($studentName, ',');
                        $studentID = rtrim($studentID, ',');
                    }
                }
                $attendee_res = $this->attendeeUrl($meeting_id, $studentName, $attendee_pw, $studentID);

                if ($attendee_res['code'] == 1) {
                    $bbburl_sendlink = $attendee_res['msg'];
                    $bbburl_sendlink = trim($bbburl_sendlink);
                    $sendlink = "<a onclick='sendlink();' class='sendlinkcls' data-sendlink='$bbburl_sendlink' style='cursor: pointer;'>Click here to join Classroom</a>";
                    $senderArr = array(
                        'group_id' => $grpid,
                        'sender_id' => $sender_id,
                        'msg' => $sendlink,
                        'date' => date('Y-m-d', strtotime($request->msg_date)),
                        'time' => $request->msg_time,
                        'is_link' => 1,
                        'is_meet_in_classroom' => 1,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );

                    $id = DB::table('chat_msg')->insertGetId($senderArr);

                    if (!empty($message->members)) {
                        $receiver = array();
                        foreach ($message->members as $uid => $uinfo) {

                            $receiver[] = array(
                                'chat_msg_id' => $id,
                                'receiver_id' => $uinfo->receiver_id,
                                'is_read' => $uinfo->is_read,
                                'status' => 0,
                            );
                        }
                        DB::table('chat_msg_status')->insert($receiver);
                    }
                   return json_encode(array('status' => 'success', 'id' => $id, 'url' => $bbb_url, 'sendlink' => $sendlink));
                } else {
                    return json_encode(array('status' => 'error'));
                }
            } else {
                return json_encode(array('status' => 'error'));
            }
        } else {
            return json_encode(array('status' => 'error'));
        }
    }


// OR

    public function event_join() {

    	if(Auth::guard('user')->check()){

        $user = Auth::guard("user")->user();

        $user_id = $user->id;
        $langCode = 'eng';

            $rand = substr(str_shuffle('0123456789'), 1, 4);

            $meeting_id = $rand . $user_id;
            $meeting_name = 'Gurure Meeting';
            $attendee_pw = 'ap' . $rand . $user_id;
            $moderator_pw = 'mp' . $rand . $user_id;

            $meeting_arr = array(
                'user_id' => $user_id,
                'meeting_id' => $meeting_id,
                'meeting_name' => $meeting_name,
                'attendee_pw' => $attendee_pw,
                'moderator_pw' => $moderator_pw,
                'is_create' => 0,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );


        $create_meeting_res = $this->createMeeting($meeting_id, $meeting_name, $attendee_pw, $moderator_pw, $user_id);

        $userId = $user->id;
        $user_name = $user->first_name . ' ' . $user->last_name;

        $moderator_res = $this->moderatorUrl($meeting_id, $user_name, $moderator_pw, $userId);
        if ($moderator_res['code'] == 1) {
            $bbb_url = $moderator_res['msg'];

            $data['start_url'] = $bbb_url;

		    return view("front/zoom",$data);

            //return json_encode(array('status' => 'success', 'url' => $bbb_url));

        } else {

            return json_encode(array('status' => 'error'));

        }

      }else{ return redirect()->to('/login'); }

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

    public function attendeeUrl($meeting_id, $user_name, $attendee_pw, $userId = '') {
        // Instatiate the BBB class:
        $bbb = new BigBlueButton();

        /* ___________ JOIN MEETING w/ OPTIONS ______ */
        /* Determine the meeting to join via meetingId and join it.
         */

        $joinParams = array(
            'meetingId' => $meeting_id, // REQUIRED - We have to know which meeting to join.
            'username' => $user_name, // REQUIRED - The user display name that will show in the BBB meeting.
            'password' => $attendee_pw, // REQUIRED - Must match either attendee or moderator pass for meeting.
            'createTime' => '', // OPTIONAL - string
            'userId' => $userId, // OPTIONAL - string
            'webVoiceConf' => ''            // OPTIONAL - string
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

    public function chatRoom()
	{
        $user_id = auth('user')->id();
        if(Auth::guard('user')->check())
		{
			$user = Auth::guard("user")->user();
			$user_id = $user->id;
			$user_name = $user->first_name.' '.$user->last_name;
			$langCode = 'eng';
			if(isset($_GET['meetingId']))
			{
				$meetingId = $_GET['meetingId'];
				$get_meeting_res = DB::table('bbb_meetings')->where('meeting_id', '=', $meetingId)->where('status', '=', 1)->first();
			}
			else
			{
				$get_meeting_res = DB::table('bbb_meetings')->where('user_id', '=', $user_id)->where('status', '=', 1)->first();
			}

			if(!empty($get_meeting_res->user_id))
			{
				$meetinginfo_response = $this->getMeetingInfo($get_meeting_res->meeting_id, $get_meeting_res->moderator_pw);
				if($meetinginfo_response['returncode'][0]=='FAILED')
				{
					DB::table('bbb_meetings')->where(['meeting_id' => $get_meeting_res->meeting_id])->update(['status'=>0,'updated_at'=>date('Y-m-d H:i:s')]);
					if(isset($_GET['meetingId']))
					{
						return redirect()->to('/customerDashboard');
					}
				}
			}

			if(empty($get_meeting_res->user_id) || $meetinginfo_response['returncode'][0]=='FAILED')
			{
				$rand = substr(str_shuffle('0123456789'), 1, 4);
				$meeting_id = $rand . $user_id;
				$meeting_name = $user_name.' Meeting';
				$attendee_pw = 'ap' . $rand . $user_id;
				$moderator_pw = 'mp' . $rand . $user_id;


				$create_meeting_res = $this->createMeeting($meeting_id, $meeting_name, $attendee_pw, $moderator_pw, $user_id);
				$userId = $user->id;
				$user_name = $user->first_name. ' ' .$user->last_name;
				$moderator_res = $this->moderatorUrl($meeting_id, $user_name, $moderator_pw, $userId);

				if($moderator_res['code'] == 1) 
				{
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
				$data['allMerchecnts'] = User::where('user_type','2')->get();

				return view('front.user.video',$data);
				} 
				else 
				{
					return json_encode(array('status' => 'error'));
				}
			}
			else
			{
				$user_id = $get_meeting_res->user_id;
				$meeting_id = $get_meeting_res->meeting_id;
				$meeting_name = $get_meeting_res->meeting_name;
				$moderator_pw = $get_meeting_res->moderator_pw;
				$meeting_url = $get_meeting_res->meeting_url;
				$bbb_url = $meeting_url;

				$data['start_url'] = $bbb_url;
				$data['user_id'] =  $user_id;
				$data['meeting_id'] =  $meeting_id;
				$data['allMerchecnts'] = User::where('user_type','2')->get();
				return view('front.user.video',$data);

			}
    	}
		else
		{
        return redirect()->to('/login');
	    }
    }

    public function get_recording($meeting_id) 
	{
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


}