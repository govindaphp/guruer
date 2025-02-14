@extends('front.layouts.layout-index')
@section('content')

<!-- Modal -->
<div class="modal fade" id="popup-login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body popup-form-login">
                <div class="login-form">
                    <div id="ajaxMessage" class="alert alert-dismissible fade show" style="display: none;">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <span class="message-content"></span>
                    </div>

                    <div class="form-register form-login">
                        <h5>Login to start learning</h5>
                        <p>Only one step left to book your lesson with guruer</p>
                        <form class="pt-0 popup--form" id="loginForm" action="{{ route('customerlogin_ajax')}}" method="POST"> {!! csrf_field() !!}
                            <input type="hidden" name="current_url" id="current_url" value="{{ url()->current() }}">
                            <div class="form-group">
								<label>Username/Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email or phone number" name="email" maxlength="60" required />
                            </div>
                            <div class="form-group">
								<label>Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" maxlength="60" required />
                            </div>
							<div class="t-c-link">
								<span>By logging in, you agree to our <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a></span>
							</div>
							<div class="mt-4 mb-2 d-grid gap-2 login-submit_btn">
                                <input type="submit" value="Sign In" class="btn btn-block btn-lg font-weight-medium auth-form-btn" />
                            </div>
							<p class="already-account">Don't have an account yet? <a href="{{ url('register') }}">Sign Up</a>
                            </p>
                            <div class="reset-pass">
                                <a href="{{ url('showLinkRequestForm')}}">Forgot Password?</a>
                            </div>
                            <div class="three-btn"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to remove the favorites status?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirmYes">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="confirmNo">No</button>
      </div>
    </div>
  </div>
</div>


<!-- this is main upper search -->
<div class="tabs advanced-guruer-tabs filter-block">
    <div class="image-box__overlay"></div>
        <div class="col-md-12">
            <div class="section-header mb-1">
                <h2 class="section-title">Title Will Goes Here</h2>
                <div class="d-flex align-items-center">
                    <p>Praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia.</p>
                </div>
            </div>
        </div>
        <div class="tab-container bg-contrast-200">
            <div class="container">
                <div class="tab-content" id="filter-properties">
                    <div class="row upper_filter g-4">
                        <div class="col-lg-3 col-md-6 col-12 select_drp">
                            <form action="{{ route('guruFilter') }}" method="POST" name="guru_search" id="guru_search">
                            {!! csrf_field() !!}

                            <label>Search By Subject</label>
                            <div class="form--search">
                                <select id="subject-select" class="nice-select nice-select-style-2 form-select" name="subject">
                                <option value="">Search by Subject</option>
                                @foreach($allUsersSubject as $sub)
                                <option value="{{@$sub->id}}">{{@$sub->subject_name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3 col-md-6 col-12 select_drp">
                            <label>Search By Guru</label>
                            <div class="form--search">
                                <select id="name-select" class="nice-select nice-select-style-2 form-select" name="name">
                                <option value="">Search by Name</option>
                                @foreach($allUsersName as $key => $value)
                                <option value="{{@$value->id}}">
                                {{@$value->first_name}}
                                </option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 select_drp multi-drp">
                            <label>Search By Language</label>
                            <select id="language-select" class="nice-select nice-select-style-2 form-select" name="language">
                                <option value="">Search by Language</option>
                                @foreach($allUsersLanguage as $sub)
                                <option value="{{@$sub->language_id}}">{{@$sub->language_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-3 col-md-6 col-6 range_qty">
                            <label>Search By Price</label>
                            <input class="price-range-slider" />
                        </div>
                    </div>
                    <div class="row g-4 lower_filter">
                        <div class="col-lg-6 col-md-6 mt-0">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 select_drp mb-3">
                                    <select id="price-select-relevance" class="form-select" aria-label="Default select example" name="price">
                                    <option selected>Sort by relevance</option>
                                    <option value="1">Price highest first</option>
                                    <option value="2">Price lowest first</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 ">
                                    <div class="form--search">
                                    <input id="keyword-text" type="text" class="form-control form-input" placeholder="Search by name or keyword..." name="search-keyword" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- this is main upper search -->
    <div class="padding-54-row-col" id="results-container">
        <div class="all-home-page">
            <div class="container rst_show">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-header mb-1">
                            <h2 class="section-title"></h2>
                        </div>
                    </div>
                </div>
                <div class="block-cgr ">
                    <div class="row result-container">
                        <div class="pagination-container">
                            <ul class="">
                                @php
                                    $user = Auth::guard("user")->user();
                                @endphp
                                @foreach($allUsers as $key => $value)
                                    <li class="outerli">
									    <div class="mylists">
										    <div class="col-12 col-lg-8 col-md-12 search-item first">
											    <div class="card border-light mb-4 item_list img-list-show">
												    <div class="row no-gutters align-items-center">
													    <div class="col-md-4 col-lg-6 col-xl-4 item_list_left">
                                                            <div class="image-extra">
                                                                <div class="options_cust">
                                                                    <a href="#"><span class="{{ $value->online_status == 1 ? 'on_line' : 'off_line' }}"></span>
                                                                    </a>
                                                                </div>
                                                                <div class="heart-icons">
                                                                    @php
                                                                        $session_user_id = $user->id ?? null;
                                                                        $profile_user_id = $value->id ?? null; // Ensure $guruer->id is handled correctly
                                                                    
                                                                        if($profile_user_id != $session_user_id){
                                                                    @endphp
                                                                    <span class="btn btn-primary atf_btn  heart_icon_color @if($session_user_id)   userfollow_heart   @endif heart_follow-content{{ $profile_user_id }}"
                                                                        @if(!$session_user_id)
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#popup-login"
                                                                        @endif
                                                                        data-item="{{ $profile_user_id }}" data-num="{{ $session_user_id }}">

                                                                        @if (getCountUserProfileFollowing($profile_user_id, $session_user_id) == 0)
                                                                            <i class="far fa-heart red-heart"></i><p style="display:none">Add to Favorites </p>
                                                                        @else
                                                                            <i class="fas fa-heart red-heart"></i><p style="display:none"> Remove from Favorites </p>
                                                                        @endif
                                                                    </span>
                                                                    @php
                                                                    }
                                                                    @endphp
                                                                </div>
                                                            </div>

                                                            <a href="{{ url('/guruerDetail', $value->id) }}">
                                                                <img
                                                                    class="img-fluid"
                                                                    src="{{ file_exists(public_path('admin/uploads/user/' . $value->profile_image)) && $value->profile_image
                                                                        ? url('public/admin/uploads/user', $value->profile_image)
                                                                        : url('public/front_assets/images/default-img.jpg') }}"
                                                                    alt=""
                                                                    class="card-img p-2 rounded-xl">
                                                            </a>
													    </div>
													    <div class="col-md-8 col-lg-6 col-xl-8 item_list_rgt new-add-item">
                                                            <div class="card-body p-3 p-md-1">
                                                                <div class="block-up">
                                                                    <a href="{{url('/guruerDetail',$value->id)}}"><h4 class="h5">{{@$value->first_name}}</h4><img src="{{ url('public/front_assets/images/check-mark.png') }}" alt="logo" class="img-fluid"></a>
                                                                        <span class="price-set">${{ $value->price }}/Hour</span>
                                                                </div>
                                                                <div class="d-flex mt-0 mb-3">
                                                                    @php
                                                                        $roundedRating = floor($value->avg_rating); // Use floor for full stars
                                                                    @endphp

                                                                    <!-- Display full stars -->
                                                                    @for ($i = 1; $i <= $roundedRating; $i++)
                                                                        <span class="star fas fa-star text-warning"></span>
                                                                    @endfor

                                                                    <!-- Display empty stars if any -->
                                                                    @for ($i = $roundedRating + 1; $i <= 5; $i++)
                                                                        <span class="star fas fa-star text-muted"></span>
                                                                    @endfor

                                                                    <!-- Display average rating -->
                                                                    <span class="badge badge-pill badge-primary ml-2">{{ number_format($value->avg_rating, 0) }}.0</span>
                                                                </div>
                                                                <ul class="list-group mb-2">
                                                                    <li class="list-group-item small p-0"><span class="fas fa-map-marker-alt mr-2"></span>{{$value->address}}</li>
                                                                    <li class="list-group-item small p-0"><span class="fas fa-bullseye mr-2"></span>Old Street (2 mins walk)</li>
                                                                </ul>
														        <div class="d-flex justify-content-between mb-3">
                                                                    <div class="col pl-0">
                                                                        <span class="text-muted font-small d-block">Speaks:</span>
                                                                        <span class="h6 text-dark font-weight-bold">{{ $value->languages }}</span>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="text-muted font-small d-block">Feature 1</span>
                                                                        <span class="h6 text-dark font-weight-bold">{{$value->subjects}}</span>
                                                                    </div>
                                                                    <div class="col pr-0">
                                                                        <span class="text-muted font-small d-block">Feature 2</span>
                                                                        <span class="h6 text-dark font-weight-bold">1200</span>
                                                                    </div>
														        </div>
															    <div class="d-flex btns-group mb-2 book-now-btn">
                                                                    <div class="btns-sets book--btn">
                                                                        @php
                                                                        $session_user_id = $user->id ?? null;
                                                                        @endphp
                                                                        <button type="button" class="btn btn-primary booknow_btn"
                                                                                @if ($session_user_id)
                                                                                    data-bs-toggle="none"
                                                                                    data-bs-target=""
                                                                                @else
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#popup-login"
                                                                                @endif>
                                                                            <i class="fas fa-book"></i> Book Now
                                                                        </button>
                                                                    </div>
                                                                    <div class="btns-sets book--btn">
                                                                        @php
                                                                        $session_user_id = $user->id ?? null;
                                                                        @endphp
                                                                        <button type="button" class="btn btn-primary booknow_btn"
                                                                                @if ($session_user_id)
                                                                                    data-bs-toggle="none"
                                                                                    data-bs-target=""
                                                                                    onclick="storeDynamicValue({{$value->id}}); window.location.href='{{ url('customerMessages') }}';"
                                                                                @else
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#popup-login"
                                                                                @endif>
                                                                            <i class="fas fa-book"></i> CHAT NOW
                                                                        </button>
                                                                    </div>
															    </div>
														    </div>
													    </div>
												    </div>
											    </div>
										    </div>

                                            @if(Auth::guard("user")->user())
                                                <div class="col-12 col-lg-4 col-md-6 video-show">
                                                    <div class="card">
                                                        <div class="ratio ratio-16x9">
                                                            @if($value->video_type == 1)
                                                                <iframe
                                                                    width="1424"
                                                                    height="652"
                                                                    src="{{ $value->video_data }}"
                                                                    title="Video player"
                                                                    frameborder="0"
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                    allowfullscreen>
                                                                </iframe>
                                                            @elseif($value->video_type == 2)
                                                            <div class="video-container">
                                                                <video width="350" height="350" class="video-player">
                                                                    <source src="{{ asset('public/admin/uploads/videos-profile/' . $value->video_data) }}" type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                                <div class="play-button-wrapper">
                                                                    <img width="50" height="50" class="play_button" src="{{ asset('public/front_assets/images/play_video.png') }}" alt="play button">
                                                                </div>
                                                            </div>
                                                            @elseif($value->video_type == 0)
                                                                <p class="text-center">No video uploaded</p>
                                                            @endif
												        </div>
											        </div>
										        </div>
                                            @endif
									    </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


<!-- JS Initialization -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        globalStartPrice = null;
        globalEndPrice = null;

        // Initialize sliders
        if ($(".price-range-slider").length) {
            $(".price-range-slider").ionRangeSlider({
                type: "double",
                prefix: "$",
                min: 1,
                max: 100,
                max_postfix: "",
                onFinish: function (data) {
                    globalStartPrice = data.from;
                    globalEndPrice = data.to;

                    fetchFilteredResults_slider(data.from, data.to);
                    $("#price-select")
                        .val(data.from + "-" + data.to)
                        .trigger("change"); // Update hidden field and trigger change
                },
            });
        }

        if ($(".area-range-slider").length) {
            $(".area-range-slider").ionRangeSlider({
                type: "double",
                min: 50,
                max: 20000,
                from: 50,
                to: 20000,
                postfix: " sqm.",
                max_postfix: "+",
            });
        }

        // Initialize switches
        if ($(".bt-switch").length) {
            $(".bt-switch").bootstrapSwitch();
        }

        function fetchFilteredResults_slider(startPrice = false, endPrice = false) {
            // Get the selected values
            const subjectValue = $("#subject-select").val();
            const nameValue = $("#name-select").val();
            const languageValue = $("#language-select").val();
            const priceValue = $("#price-select-relevance").val();
            const keywordTextValue = $("#keyword-text").val();

            const startPriceValue = startPrice;
            const endPriceValue = endPrice;

            // Show the loading spinner
            //$('#loading-spinner').show();
            $("#results-container").html("<div class='text-center'><img src='{{ asset('public/admin/assets/images/lg.gif') }}' alt='Loading...'></div>");
            // Make AJAX request to fetch filtered results
            $.ajax({
                url: "{{ route('gururesults') }}", // Laravel route for loading results
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    subject: subjectValue,
                    name: nameValue,
                    language: languageValue,
                    price: priceValue,
                    keyword: keywordTextValue,
                    startprice: startPriceValue,
                    endprice: endPriceValue,
                },
                success: function (response) {
                    // Update the results container with the new data
                    $("#results-container").html(response);

                    const ulElement = $("#results-container ul");
                    if (ulElement.find("li").length === 0) {
                        $("#results-container").html("<p class='text-center no-data-text'>No data found</p>");
                    }

                    initializePagination();
                    initializeHoverEffect();
                    stopvideo_autoplay();
                    userfollow_heart_clk();
                },
                error: function () {
                    alert("An error occurred while fetching results.");
                },
                complete: function () {
                    // Hide the loading spinner once the request is complete
                    //$('#loading-spinner').hide();
                },
            });
        }

        // Trigger AJAX request on dropdown value change
        $('#subject-select, #name-select, #language-select, #price-select-relevance, #keyword-text').on('change keyup', fetchFilteredResults);
    });

    function initializePagination() {
        $(".pagination-container").each(function () {
            var foo = $(this);

            // Check if already initialized
            if (foo.data("pagination-initialized")) {
                return;
            }
            foo.data("pagination-initialized", true);

            // Clear any existing pagination controls
            foo.find(".pagination-controls").remove();

            // Append navigation buttons and a number indicator
            foo.append('<div class="pagination-controls">' + '<a class="prev">Prev</a> <span class="pagination-numbers"></span> <a class="next">Next</a> <span class="page-indicator"></span>' + "</div>");

            // Initial setup
            var totalItems = foo.find("ul li.outerli").length; // Count <li> with class="outerli"
            var itemsPerPage = 5; // Number of items per page
            var totalPages = Math.ceil(totalItems / itemsPerPage);
            var currentPage = foo.data("current-page") || 1; // Use stored current page or default to 1
            var maxVisiblePages = 3;

            // Update page indicator
            function updatePageIndicator() {
                var firstVisible = (currentPage - 1) * itemsPerPage + 1;
                var lastVisible = Math.min(currentPage * itemsPerPage, totalItems);
                foo.find(".page-indicator").text(`Showing ${firstVisible}-${lastVisible} of ${totalItems}`);
            }

            // Render pagination
            function renderPagination() {
                var paginationHtml = "";
                var startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                var endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                startPage = Math.max(1, Math.min(startPage, totalPages - maxVisiblePages + 1));

                for (var i = startPage; i <= endPage; i++) {
                    if (i === currentPage) {
                        paginationHtml += `<a class="page-number active" data-page="${i}">${i}</a>`;
                    } else {
                        paginationHtml += `<a class="page-number" data-page="${i}">${i}</a>`;
                    }
                }

                foo.find(".pagination-numbers").html(paginationHtml);
            }

            // Show items for a page
            function showPage(page) {
                var start = (page - 1) * itemsPerPage;
                var end = start + itemsPerPage;

                foo.find("ul li.outerli").hide().slice(start, end).show();

                currentPage = page;
                foo.data("current-page", currentPage); // Store the current page
                renderPagination();
                updatePageIndicator();
            }

            // Show the first page or stored page on load
            showPage(currentPage);

            // Pagination controls
            foo.find(".next").click(function () {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            foo.find(".prev").click(function () {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            foo.on("click", ".page-number", function () {
                var page = parseInt($(this).data("page"));
                showPage(page);
            });
        });
    }

    // Call the function on document ready or AJAX success
    $(document).ready(function () {
        initializePagination();
    });


    function initializeHoverEffect() {
        // Get all list items and video-show elements
        const listItems = document.querySelectorAll("li.outerli");

        if (listItems.length > 0) {
            const firstItem = listItems[0];

            // Initialize the first item as active
            if (firstItem) {
                firstItem.querySelector(".video-show").classList.add("active");
            }

            listItems.forEach((li) => {
                const searchItem = li.querySelector(".search-item");
                const videoShow = li.querySelector(".video-show");

                // Ensure searchItem exists before adding the event listener
                if (searchItem && videoShow) {
                    // Add hover event for each search item
                    searchItem.addEventListener("mouseenter", () => {
                        // Remove active class from all video-show elements
                        document.querySelectorAll("li .video-show").forEach((el) => {
                            el.classList.remove("active");
                        });

                        // Add active class to the hovered item's video-show
                        videoShow.classList.add("active");
                    });
                }
            });

            // Keep the last active class even when hovering out
            document.addEventListener("mouseleave", (e) => {
                const isHoveringInsideList = Array.from(listItems).some((li) => li.contains(e.target));

                if (!isHoveringInsideList) {
                    const activeVideoShow = document.querySelector("li .video-show.active");
                    if (!activeVideoShow && firstItem) {
                        firstItem.querySelector(".video-show").classList.add("active");
                    }
                }
            });
        }
    }

    function fetchFilteredResults() {
        //alert('hello xxxxxx');
        // Get the selected values
        const subjectValue = $("#subject-select").val();
        const nameValue = $("#name-select").val();
        const languageValue = $("#language-select").val();
        const priceValue = $("#price-select-relevance").val();
        const keywordTextValue = $("#keyword-text").val();

        const startPriceValue = globalStartPrice !== null && globalStartPrice !== undefined ? globalStartPrice : 1;
        const endPriceValue = globalEndPrice !== null && globalEndPrice !== undefined ? globalEndPrice : 100;

        // Show the loading spinner
        //$('#loading-spinner').show();
        $("#results-container").html("<div class='text-center'><img src='{{ asset('public/admin/assets/images/lg.gif') }}' alt='Loading...'></div>");

        // Make AJAX request to fetch filtered results
        $.ajax({
            url: "{{ route('gururesults') }}", // Laravel route for loading results
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}", // CSRF token for security
                subject: subjectValue,
                name: nameValue,
                language: languageValue,
                price: priceValue,
                keyword: keywordTextValue,
                startprice: startPriceValue,
                endprice: endPriceValue,
            },
            success: function (response) {
                // Update the results container with the new data
                $("#results-container").html(response);

                const ulElement = $("#results-container ul");
                if (ulElement.find("li").length === 0) {
                    $("#results-container").html("<p class='text-center no-data-text'>No data found</p>");
                }

                initializePagination();
                initializeHoverEffect();
                stopvideo_autoplay();
                userfollow_heart_clk();
            },
            error: function () {
                alert("An error occurred while fetching results.");
            },
            complete: function () {
                    // Hide the loading spinner once the request is complete
                    //$('#loading-spinner').hide();
            },
        });
    }

    $(document).ready(function () {
        initializeHoverEffect();
        stopvideo_autoplay();
        userfollow_heart_clk();
    });



    $(document).ready(function () {
        $("#loginForm").on("submit", function (e) {
            $("#ajaxMessage").addClass("show");
            e.preventDefault(); // Prevent default form submission

            const formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: $(this).attr("action"), // Use form's action URL
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        // Show success message
                        $("#ajaxMessage")
                            .hide() // Ensure it's hidden before showing
                            .removeClass("alert-danger")
                            .addClass("alert alert-success")
                            .text(response.message || "Login successful!")
                            .fadeIn() // Smooth fade-in effect
                            .delay(1000) // Delay before fading out
                            .fadeOut();

                        // Redirect to the specified URL
                        setTimeout(() => {
                            window.location.href = response.redirect_url || "/";
                        }, 1500);
                    } else {
                        // Show error message
                        $("#ajaxMessage")
                            .hide()
                            .removeClass("alert-success")
                            .addClass("alert alert-danger")
                            .text(response.message || "Invalid login credentials.")
                            .fadeIn() // Smooth fade-in effect
                            .delay(1000) // Delay before fading out
                            .fadeOut();
                    }
                },
                error: function (xhr) {
                    // Handle validation or server errors
                    let errorMsg = "Login failed. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $("#ajaxMessage")
                        .hide()
                        .removeClass("alert-success")
                        .addClass("alert alert-danger")
                        .text(errorMsg)
                        .fadeIn() // Smooth fade-in effect
                        .delay(1000) // Delay before fading out
                        .fadeOut();
                },
            });
        });
    });


    function userfollow_heart_clk(){
    $(".userfollow_heart").click(function () {
        var button = $(this);

        // Get the full HTML content of the button
        var status_msg_old = button.html().trim();
        console.log("Old Status Message (HTML):", status_msg_old);

        // Determine if the current action is to remove or add to favorites
        var isRemove = status_msg_old.includes("Remove from Favorites");

        // Update the status messages based on the current state
        var status_msg = isRemove
            ? '<i class="far fa-heart red-heart"></i> Add to Favorites'
            : '<i class="fas fa-heart red-heart"></i> Remove from Favorites';

        var status_msg_heart = isRemove
            ? '<i class="far fa-heart red-heart"></i><p style="display:none"> Add to Favorites </p>'
            : '<i class="fas fa-heart red-heart"></i><p style="display:none"> Remove from Favorites </p>';

        // If removing, show the confirmation modal
        if (isRemove) {
            $("#confirmationModal")
                .data({
                    user_id: button.attr("data-item"),
                    sender_user_id: button.attr("data-num"),
                    status_msg: status_msg,
                    status_msg_heart: status_msg_heart,
                    button: button
                })
                .modal('show');
        } else {
            // Directly add to favorites
            executeProcess(button.attr("data-item"), button.attr("data-num"), status_msg, status_msg_heart, false);
        }
    });

    // Handle the confirmation modal's "Yes" button
    $("#confirmYes").click(function () {
        var modal = $("#confirmationModal");
        var user_id = modal.data("user_id");
        var sender_user_id = modal.data("sender_user_id");
        var status_msg = modal.data("status_msg");
        var status_msg_heart = modal.data("status_msg_heart");

        // Close the modal
        modal.modal('hide');

        // Execute the removal process
        executeProcess(user_id, sender_user_id, status_msg, status_msg_heart, true);
    });
}

    // Function to execute the process
    function executeProcess(user_id, sender_user_id, status_msg, status_msg_heart, isRemove) {
        if (user_id) {
            if (sender_user_id == user_id) {
                alert("You cannot favorite yourself.");
            } else {
                var baseUrl = $('meta[name="base-url"]').attr("content") || window.location.origin;
                var ajaxUrl = baseUrl + "/favorites_users_ajax";

                $.ajax({
                    type: "POST",
                    url: ajaxUrl,
                    data: {
                        sender: sender_user_id,
                        user: user_id,
                        _token: "{{ csrf_token() }}",
                    },

                    success: function (response) {
                        // Update the button content
                        $(".heart_follow-content" + user_id).html(status_msg_heart);

                        // Update the badge counter
                        var badge = $(".update_heart_ajax");
                        var currentCount = parseInt(badge.text()) || 0;

                        if (isRemove) {
                            badge.text(Math.max(currentCount - 1, 0));
                        } else {
                            badge.text(currentCount + 1);
                        }

                        // Refresh the wishlist dropdown
                        refreshWishlist();
                    },
                    error: function () {
                        console.error("Failed to update the favorite status.");
                    },
                });
            }
        } else {
            window.location.href = login_url;
        }
    }
</script>


<script>
    function storeDynamicValue(value) {
        sessionStorage.setItem("dynamicValue", value);
    }
</script>