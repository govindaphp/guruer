<div class="preloader-wrapper">

    <div class="preloader">

    </div>

  </div>





  <header>

  

    <div class="container start-flow">

      <div class="row py-3 header-row">



        <div class="col-sm-4 col-lg-3 text-center text-sm-start">

          <div class="main-logo">

            <a href="{{ url('/') }}">

              <img src="{{ url('/public') }}/front_assets/images/guruer-logo.png" alt="logo"  width="200px"  height="auto">

            </a>

          </div>

        </div>


<!-- //gap-5  removed -->
        <div class="col-sm-8 col-lg-3 d-flex justify-content-end align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end user-top-drop">

          @if (Auth::guard("user")->check()) 
          @php
            $user = Auth::guard("user")->user();
          @endphp
          @if ($user && $user->user_type == 1)
          <a href="{{url('customerDashboard')}}"> 
            <i class='fas fa-user-circle' style="color: green;"><span style="color: black;" class="inner-top-value">{{ Auth::guard('user')->user()->first_name }}</span></i>
          </a>
          @else
			  

          <div class="atw-noti">
            <i class="far fa-heart"></i>
          </div>
		  <div class="nav-item dropdown chat-noti">
			<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="far fa-envelope"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">{{ $chats->count() }}</span>
                            </a>
			<div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0 chatnoti-open">
				<h6 class="dropdown-header">
            Messages
        </h6>
            @if($chats->isNotEmpty())
            @foreach($chats->take(4) as $chat)
            <a class="dropdown-item d-flex align-items-center" href="{{ url('/vendorMessages') }}">
                <div class="dropdown-list-image mr-3"> 
                <img class="rounded-circle" src="{{ file_exists(public_path('admin/uploads/user/' . $chat->profile_image)) && $chat->profile_image 
                  ? url('public/admin/uploads/user', $chat->profile_image) 
                  : url('public/front_assets/images/default-img.jpg') }}" 
                 alt="..." >
                    <div class="{{ $chat->online_status == 1 ? 'status-indicator bg-success' : 'bg-success' }}"></div>
                </div>
                <div class="{{ $loop->first ? 'font-weight-bold' : '' }}">
                    <div class="text-truncate">{{ $chat->msg }}</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                </div>
            </a>
            @endforeach
                <a class="dropdown-item text-center small text-gray-500" href="{{ url('/vendorMessages') }}">Read More Messages</a>
            @else
                <a class="dropdown-item text-center small text-gray-500" href="#">No messages available</a>
            @endif
                                
			</div>
		  </div>
						
						
		  <div class="topbar-divider d-none d-sm-block"></div>
		  <div class="nav-item dropdown profile-drpdn">
			<a href="{{url('vendorsDasboard')}}" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
				<img class="rounded-circle me-lg-2" src="{{ file_exists(public_path('admin/uploads/user/' . Auth::guard('user')->user()->profile_image)) && Auth::guard('user')->user()->profile_image   ? url('public/admin/uploads/user', Auth::guard('user')->user()->profile_image)   : url('public/front_assets/images/default-img.jpg') }}" alt="" style="width: 40px; height: 40px;">
					<div class="status_view">
					 <span class="view-circle"></span>
					</div>
			</a>
			<div class="dropdown-menu profile-toggle dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
			<div class="head-drpdn">
				<img class="rounded-circle me-lg-2" src="{{ file_exists(public_path('admin/uploads/user/' . Auth::guard('user')->user()->profile_image)) && Auth::guard('user')->user()->profile_image   ? url('public/admin/uploads/user', Auth::guard('user')->user()->profile_image)   : url('public/front_assets/images/default-img.jpg') }}" alt="" style="width: 40px; height: 40px;">
				<span style="color: #fff;" class="inner-top-value">{{ Auth::guard('user')->user()->first_name }}</span>
			</div>
			<div class="inner-drpmenu">
				<a href="{{ url('/vendorsDasboard') }}" class="dropdown-item"><i class="far fa-user"></i> My Profile</a>
				<a href="{{ url('/vendorMessages') }}" class="dropdown-item"><i class="far fa-envelope"></i> Inbox</a>
				<a href="{{ url('/vendorMessages') }}" class="dropdown-item"><i class="far fa-comment"></i> Chat</a>
				<hr> 
				<a href="{{ url('/ProfileSetting') }}" class="dropdown-item"><i class="fas fa-sliders-h"></i> Setting</a>
				<a href="#" class="dropdown-item"><i class="fas fa-dollar-sign"></i> Pricing</a>
				<a href="#" class="dropdown-item"><i class="fas fa-question"></i> FAQ</a>
				<hr>         
				<a href="{{ url('/logout') }}" class="dropdown-item logout_menu"><i class="fas fa-sign-out-alt"></i> Logout</a>
			</div>
			</div>
		</div>
          @endif
          @endif 

          @if (Auth::guard("user")->check() || Auth::guard("vendor")->check()) 
			  
		  
		
         

          @else



          <ul class="d-flex justify-content-end list-unstyled m-0 dual_btn">

              <li class="loginbtn"><a href="{{ url('/login') }}">Login</a></li>

              <li class="signupbtn"><a href="{{ url('/register') }}">Sign Up</a></li>

            </ul>

          @endif 

        </div>



      </div>

    </div>

	

  </header>

