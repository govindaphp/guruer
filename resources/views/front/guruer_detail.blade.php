@extends('front.layouts.layout') @section('content')
@php
use Carbon\Carbon;
@endphp
<style>
    #full-stars-example {

        /* use display:inline-flex to prevent whitespace issues. alternatively, you can put all the children of .rating-group on a single line */
        .rating-group {
            display: inline-flex;
        }

        /* make hover effect work properly in IE */
        .rating__icon {
            pointer-events: none;
        }

        /* hide radio inputs */
        .rating__input {
            position: absolute !important;
            left: -9999px !important;
        }

        /* set icon padding and size */
        .rating__label {
            cursor: pointer;
            padding: 0 0.1em;
            font-size: 2rem;
        }

        /* set default star color */
        .rating__icon--star {
            color: orange;
        }

        /* set color of none icon when unchecked */
        .rating__icon--none {
            color: #eee;
        }

        /* if none icon is checked, make it red */
        .rating__input--none:checked+.rating__label .rating__icon--none {
            color: red;
        }

        /* if any input is checked, make its following siblings grey */
        .rating__input:checked~.rating__label .rating__icon--star {
            color: #ddd;
        }

        /* make all stars orange on rating group hover */
        .rating-group:hover .rating__label .rating__icon--star {
            color: orange;
        }

        /* make hovered input's following siblings grey on hover */
        .rating__input:hover~.rating__label .rating__icon--star {
            color: #ddd;
        }

        /* make none icon grey on rating group hover */
        .rating-group:hover .rating__input--none:not(:hover)+.rating__label .rating__icon--none {
            color: #eee;
        }

        /* make none icon red on hover */
        .rating__input--none:hover+.rating__label .rating__icon--none {
            color: red;
        }
    }

    #half-stars-example {

        /* use display:inline-flex to prevent whitespace issues. alternatively, you can put all the children of .rating-group on a single line */
        .rating-group {
            display: inline-flex;
        }

        /* make hover effect work properly in IE */
        .rating__icon {
            pointer-events: none;
        }

        /* hide radio inputs */
        .rating__input {
            position: absolute !important;
            left: -9999px !important;
        }

        /* set icon padding and size */
        .rating__label {
            cursor: pointer;
            /* if you change the left/right padding, update the margin-right property of .rating__label--half as well. */
            padding: 0 0.1em;
            font-size: 2rem;
        }

        /* add padding and positioning to half star labels */
        .rating__label--half {
            padding-right: 0;
            margin-right: -0.6em;
            z-index: 2;
        }

        /* set default star color */
        .rating__icon--star {
            color: orange;
        }

        /* set color of none icon when unchecked */
        .rating__icon--none {
            color: #eee;
        }

        /* if none icon is checked, make it red */
        .rating__input--none:checked+.rating__label .rating__icon--none {
            color: red;
        }

        /* if any input is checked, make its following siblings grey */
        .rating__input:checked~.rating__label .rating__icon--star {
            color: #ddd;
        }

        /* make all stars orange on rating group hover */
        .rating-group:hover .rating__label .rating__icon--star,
        .rating-group:hover .rating__label--half .rating__icon--star {
            color: orange;
        }

        /* make hovered input's following siblings grey on hover */
        .rating__input:hover~.rating__label .rating__icon--star,
        .rating__input:hover~.rating__label--half .rating__icon--star {
            color: #ddd;
        }

        /* make none icon grey on rating group hover */
        .rating-group:hover .rating__input--none:not(:hover)+.rating__label .rating__icon--none {
            color: #eee;
        }

        /* make none icon red on hover */
        .rating__input--none:hover+.rating__label .rating__icon--none {
            color: red;
        }
    }

    #full-stars-example-two {

        /* use display:inline-flex to prevent whitespace issues. alternatively, you can put all the children of .rating-group on a single line */
        .rating-group {
            display: inline-flex;
        }

        /* make hover effect work properly in IE */
        .rating__icon {
            pointer-events: none;
        }

        /* hide radio inputs */
        .rating__input {
            position: absolute !important;
            left: -9999px !important;
        }

        /* hide 'none' input from screenreaders */
        .rating__input--none {
            display: none
        }

        /* set icon padding and size */
        .rating__label {
            cursor: pointer;
            padding: 0 0.1em;
            font-size: 2rem;
        }

        /* set default star color */
        .rating__icon--star {
            color: orange;
        }

        /* if any input is checked, make its following siblings grey */
        .rating__input:checked~.rating__label .rating__icon--star {
            color: #ddd;
        }

        /* make all stars orange on rating group hover */
        .rating-group:hover .rating__label .rating__icon--star {
            color: orange;
        }

        /* make hovered input's following siblings grey on hover */
        .rating__input:hover~.rating__label .rating__icon--star {
            color: #ddd;
        }
    }

    .language-list {
        list-style-type: none;
        /* Removes default bullet points */
        padding: 0;
        /* Removes default padding */
        margin: 0;
        /* Removes default margin */
        display: flex;
        /* Makes the list items display in a row */
        gap: 10px;
        /* Adds space between list items */
    }

    .language-list li {
        background-color: #f0f0f0;
        /* Adds a light gray background */
        padding: 5px 10px;
        /* Adds padding inside each list item */
        border-radius: 4px;
        /* Rounds the corners */
        font-size: 14px;
        /* Adjusts font size */
    }



    .heart_icon_color {
        background: #fff;
        border: cadetblue;
        color: black;
        border-radius: 50px;
        width: 35px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .heart_icon_color:hover {
        background: #fff !important;
        color: black;
    }
</style>

<!-- <div id="confirmationModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:1000; background-color:#fff; padding:20px; box-shadow:0px 4px 6px rgba(0,0,0,0.1);">
    <p>Are you sure you want to Remove the favorites status?</p>
    <button id="confirmYes">Yes</button>
    <button id="confirmNo">No</button>
</div>
<div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div> -->



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





<div class="banner-tailors">
    <div class="container browse-tailors">
        <div class="row browse-content">
            <h1 class="text-white">Guruer Detail</h1>
        </div>
    </div>
</div>
<div class="single_det-info">
    <div class="container rst_show">
        <div class="block-cgr ">
            <div class="row result-container">
                <div class="pagination-container">
                    <ul class="">
                        <li class="outerli" style="display: list-item;">
                            <div class="mylists">
                                <div class="col-12 col-lg-8 col-md-12 search-item first ">
                                    <div class="card border-light mb-4 item_list img-list-show about-info1">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 col-lg-6 col-xl-4 item_list_left">
                                                <div class="image-extra">
                                                    <div class="options_cust">
                                                        <a href="#">
                                                            <span class="{{ $guruer->online_status == 1 ? 'on_line' : 'off_line' }}"></span>
                                                        </a>
                                                    </div>
                                                    <div class="heart-icons">
                                                        <!-- <span class="heart-right"><i class="far fa-heart red-heart"></i></span> -->



                                                        @php
                                                        $user = Auth::guard("user")->user();
                                                        $session_user_id = $user->id ?? null;
                                                        $profile_user_id = $guruer->id ?? null; // Ensure $guruer->id is handled correctly

                                                        @endphp


                                                        @php
                                                        if($profile_user_id != $session_user_id){
                                                        @endphp
                                                        <span
                                                            class="btn btn-primary atf_btn  heart_icon_color
            @if($session_user_id)
                @if($session_user_id)
                    userfollow_heart
                @endif
            @else
                user---follow
            @endif
            heart_follow-content{{ $profile_user_id }}"

                                                            @if(!$session_user_id)
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#popup-login"
                                                            @endif


                                                            @if ($guruer->user_status == 0)
                                                            style="pointer-events: none; color: white !important;"
                                                            @endif

                                                            data-item="{{ $profile_user_id }}"
                                                            data-num="{{ $session_user_id }}">

                                                            @if (getCountUserProfileFollowing($profile_user_id, $session_user_id) == 0)
                                                            <i class="far fa-heart red-heart"></i>
                                                            <p style="display:none">Add to Favorites </p>
                                                            @else
                                                            <i class="fas fa-heart red-heart"></i>
                                                            <p style="display:none"> Remove from Favorites </p>
                                                            @endif
                                                        </span>
                                                        @php
                                                        }
                                                        @endphp




                                                    </div>
                                                </div>
                                                <!-- <a href="https://guruer.com/guruerDetail ,$value-&gt;id" ><img class="img-fluid card-img p-2 rounded-xl" src="https://guruer.com/public/admin/uploads/user/cus1733491065.jpg" alt="" class="card-img p-2 rounded-xl"></a> -->

                                                <a href="{{ url('guruerDetail', $guruer->id) }}">
                                                    <img class="img-fluid" src="{{ file_exists(public_path('admin/uploads/user/' . $guruer->profile_image)) && $guruer->profile_image ? url('public/admin/uploads/user', $guruer->profile_image) : url('public/front_assets/images/default-img.jpg') }}" alt="">
                                                </a>
                                            </div>
                                            <div class="col-md-8 col-lg-6 col-xl-8 item_list_rgt new-add-item">
                                                <div class="card-body p-3 p-md-1">
                                                    <div class="block-up">
                                                        <a href="{{url('/guruerDetail',$guruer->id)}}">
                                                            <h4 class="h5">{{@$guruer->first_name}}</h4>
                                                            <img src="{{ url('public/front_assets/images/check-mark.png') }}" alt="logo" class="img-fluid">
                                                        </a>
                                                        <span class="price-set">${{ $guruer->price }}/Hour</span>
                                                    </div>
                                                    <div class="d-flex mt-0 mb-3">
                                                        @php
                                                            $roundedRating = floor($rating_avg); // Use floor to determine the number of solid stars
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
                                                        <span class="badge badge-pill badge-primary ml-2">{{ $rating_avg }}.0</span>
                                                    </div>

                                                    <ul class="list-group mb-2">
                                                        <li class="list-group-item small p-0">
                                                            <span class="fas fa-map-marker-alt mr-2"></span>{{$guruer->address}}
                                                        </li>
                                                        <li class="list-group-item small p-0">
                                                            <span class="fas fa-bullseye mr-2"></span>Old Street (2 mins walk)
                                                        </li>
                                                    </ul>
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <div class="col pl-0">
                                                            <span class="text-muted font-small d-block">Speaks:</span>
                                                            <span class="h6 text-dark font-weight-bold">{{ $guruer->languages }}</span>
                                                        </div>
                                                        <div class="col">
                                                            <span class="text-muted font-small d-block">Feature 1</span>
                                                            <span class="h6 text-dark font-weight-bold">{{$guruer->subjects}}</span>
                                                        </div>
                                                        <div class="col pr-0">
                                                            <span class="text-muted font-small d-block">Feature 2</span>
                                                            <span class="h6 text-dark font-weight-bold">1200</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row feature-tabs">
                                            <div class="tabmenu">
                                                <div id="features" class="sticky">
                                                    <div class="" id="tab-center">
                                                        <ul class="list-menu">
                                                            <li>
                                                                <a href="#about" class="active">About</a>
                                                            </li>
                                                            <li>
                                                                <a href="#courses">Courses</a>
                                                            </li>
                                                            <li>
                                                                <a href="#reviews-rating">Reviews</a>
                                                            </li>
                                                            <li>
                                                                <a href="#subjects">Subjects</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-light mb-4 about-data1">
                                        <div class="row about_info" id="about">
                                            <div class="tabtitle">
                                                <h2>About</h2>
                                            </div>
                                            <div class="about--info">
                                                <h4>About the tutor</h4>
                                                <p>English language teacher</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-light mb-4 about-data1">
                                        <div class="row about_info" id="courses">
                                            <div class="tabtitle">
                                                <h2>Guruers</h2>
                                            </div>
                                            <div class="about--info">
                                                <h4>Guruers List</h4>
                                            </div>
                                            <div class="slider-course">
                                                <div id="course-slider" class="owl-carousel">
                                                    @if($guruer_for_slider->isNotEmpty())
                                                        @foreach($guruer_for_slider as $guruer_slider)
                                                            <div class="course-slide">
                                                                <div class="course-img">
                                                                    <div class="inner-images-part">
                                                                        <a href="{{ url('guruerDetail', $guruer_slider->id) }}">
                                                                            <img class="img-fluid"
                                                                                src="{{ file_exists(public_path('admin/uploads/user/' . $guruer_slider->profile_image)) && $guruer_slider->profile_image
                                                                                    ? url('public/admin/uploads/user', $guruer_slider->profile_image)
                                                                                    : url('public/front_assets/images/default-img.jpg') }}"
                                                                                alt="">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="course-content">
                                                                    <h3 class="course-title">
                                                                        <a href="{{ url('guruerDetail', $guruer_slider->id) }}">{{ $guruer_slider->first_name }}</a>
                                                                    </h3>
                                                                    <div class="d-flex mt-0 mb-3">
                                                                        @php
                                                                            $roundedRating = floor($guruer_slider->avg_rating); // Use floor for full stars
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
                                                                        <span class="badge badge-pill badge-primary ml-2">{{ number_format($guruer_slider->avg_rating, 0) }}.0</span>
                                                                    </div>
                                                                    <a href="#" class="read-more">BOOK Now</a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>No users available for the slider.</p>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @if(count($review_data))
                                    <div class="card border-light mb-4 about-data1">
                                        <div class="row about_info" id="reviews-rating">
                                            <div class="tabtitle">
                                                <h2>Ratings and Reviews</h2>
                                            </div>
                                            <div class="bg-white p-4 mb-4 clearfix graph-star-rating cust-rating">
                                                <div class="graph-star-rating-body">
                                                    @foreach ($star_rating_show as $star => $percentage)
                                                        <div class="rating-list">
                                                            <div class="rating-list-left text-black">
                                                                {{ $star }} Star
                                                            </div>
                                                            <div class="rating-list-center">
                                                                <div class="progress">
                                                                    <div
                                                                        style="width: {{ $percentage }}%"
                                                                        aria-valuemax="100"
                                                                        aria-valuemin="0"
                                                                        aria-valuenow="{{ $percentage }}"
                                                                        role="progressbar"
                                                                        class="progress-bar bg-primary">
                                                                        <span class="sr-only">{{ $percentage }}% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="rating-list-right text-black">
                                                                {{ $percentage }}%
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row about_info" id="about">
                                            <div class="tabtitle">
                                                <h4>All Ratings and Reviews</h4>
                                            </div>

                                            <?php $i = 1; ?>
                                            @foreach ($review_data as $key => $data)
                                                <div class="reviews-members pt-4 pb-4 review-item {{ $key >= 2 ? 'd-none' : '' }}">
                                                    <div class="media">
                                                        <a href="#"><img alt="Review Image" src="{{ url('public/front_assets/images/profile.png') }}" class="mr-3 rounded-pill"></a>
                                                        <div class="media-body">
                                                            <div class="reviews-members-header">
                                                                <span class="star-rating float-right">
                                                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                                                    <a href="#"><i class="icofont-ui-rating"></i></a>
                                                                </span>
                                                                <h6 class="mb-0"><a class="text-black" href="#">{{$data->first_name}}</a></h6>
                                                                <p class="text-gray">{{ Carbon::parse($data->created_at)->format('D, d M Y') }}</p>
                                                            </div>
                                                            <div class="reviews-members-body">
                                                                <p>{{$data->review_text}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; ?>
                                                @if ($i != count($review_data))
                                                    <hr class="{{ $key >= 2 ? 'd-none' : '' }}"/>
                                                @endif
                                            @endforeach

                                            <div class="line">
                                                <hr>
                                            </div>

                                            <div class="allreview">
                                                <a href="#" id="see-all-reviews">See All Reviews</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                    @if (Auth::guard('user')->check() && Auth::guard('user')->user()->user_type == 1)
                                    <div class="post-review-box" id="post-review-box">
                                        <div class="col-md-12">

                                            <h2>Write your review</h2>
                                            <div class="msg-box">
                                                <div id="message-box" style="display:none;">
                                                    <i class="fa fa-check"></i>
                                                    <span id="message"></span>
                                                    <!-- <button aria-hidden="true" data-dismiss="alert" class="close" id="remove_box"
                                                    type="button">x</button> -->
                                                </div>
                                            </div>
                                            <form accept-charset="UTF-8" id="review-rating-form" action="javascript:void(0);"
                                                method="post">
                                                {{ csrf_field() }}
                                                <input name="vendor_id" type="hidden" value="{{$guruer->id}}">
                                                <input name="user_id" type="hidden" value="{{Auth::guard("user")->id()}}">
                                                <textarea class="form-control animated" cols="50" id="review-text" name="comment"
                                                    placeholder="Enter your review here..." rows="5" required></textarea>
                                                <div class="text-right">

                                                    <div id="full-stars-example-two">
                                                        <div class="rating-group">
                                                            <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">
                                                            <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                                                            <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                                                            <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                                                            <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                                                            <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-success btn-lg" type="button"
                                                        id="submit-review">Submit Review</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endif


                                    <div class="card border-light mb-4 about-data1">
                                        <div class="row about_info" id="subjects">
                                            <div class="tabtitle">
                                                <h2>Subjects</h2>
                                            </div>
                                            <div class="about--info">
                                                <h4>About the Subject</h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-lg-4 col-md-6 video-show active">
                                    <div class="card video-fixed">
                                        <div class="ratio ratio-16x9">
                                            <!--
                                            <iframe width="1424" height="652" src="https://www.youtube.com/embed/NAMvdbS4lk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                                            -->

                                            @if($guruer->video_type == 1)
                                            <iframe
                                                width="1424"
                                                height="652"
                                                src="{{ $guruer->video_data }}"
                                                title="Video player"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                            @elseif($guruer->video_type == 2)
                                            <video width="1424" height="652" controls>
                                                <source src="{{ asset('public/admin/uploads/videos-profile/' . $guruer->video_data) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            @elseif($guruer->video_type == 0)
                                            <p class="text-center">No video uploaded</p>
                                            @endif
                                        </div>
                                        <div class="card-body info-video">
                                            <div class="block-up video_head">
                                                <span class="status_od">New tutor</span>
                                                <div class="price-flex">
                                                    <p class="price-set">${{ $guruer->price }}/Hour</p>
                                                    <b>Price per hour</b>
                                                </div>
                                            </div>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                                        </div>
                                        <div class="btns-sets book--btn">
                                            <!-- Button trigger modal -->
                                            <!-- <button type="button" class="btn btn-primary booknow_btn" data-bs-toggle="modal" data-bs-target="#popup-login">
                                                <i class="fas fa-book"></i> Book Now
                                            </button> -->


                                            @php
                                            $user = Auth::guard("user")->user();
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

                                            <!-- <button type="button" class="btn btn-primary chatnow_btn" data-bs-toggle="modal" data-bs-target="#popup-login">
                                                <i class="far fa-envelope"></i> Send Message
                                            </button> -->

                                            <button type="button" class="btn btn-primary chatnow_btn"
                                                @if ($session_user_id)

                                                data-bs-toggle="none"
                                                data-bs-target=""
                                                @else
                                                data-bs-toggle="modal"
                                                data-bs-target="#popup-login"
                                                @endif>
                                                <i class="far fa-envelope"></i> Send Message
                                            </button>


                                            <!-- <button type="button" class="btn btn-primary atf_btn" data-bs-toggle="modal" data-bs-target="#popup-login">
                                                <i class="far fa-heart"></i> Add to Favorites </a>
                                            </button> -->



                                            <!-- @php
                                                $user = Auth::guard("user")->user();
                                                $session_user_id = $user->id ?? null;
                                                $profile_user_id = $guruer->id ?? null; // Ensure $guruer->id is handled correctly

                                            @endphp -->

                                            <!--
                                            <button type="button"
                                                    class="btn btn-primary atf_btn userfollow follow-content{{ $profile_user_id }}"
                                                    data-bs-toggle=""
                                                    data-bs-target="#popup-login"

                                                    @if ( (is_null($session_user_id) || empty($session_user_id) ) || ( $session_user_id == $profile_user_id )   ) disabled @endif
                                                    @if ($guruer->user_status == 0) style="pointer-events: none; color: white !important;" @endif
                                                    data-item="{{ $profile_user_id }}"
                                                    data-num="{{ $session_user_id }}">
                                                @if (getCountUserProfileFollowing($profile_user_id, $session_user_id) == 0)
                                                <i class="far fa-heart red-heart"></i> Add to Favorites
                                                @else
                                                <i class="fas fa-heart red-heart"></i> Remove from Favorites
                                                @endif
                                            </button>
                                            -->

                                            @php
                                            if($profile_user_id != $session_user_id){
                                            @endphp
                                            <button type="button"
                                                class="btn btn-primary atf_btn
                                                    @if($session_user_id)
                                                        @if($session_user_id)
                                                            userfollow
                                                        @endif
                                                    @else
                                                        user---follow
                                                    @endif
                                                    follow-content{{ $profile_user_id }}"

                                                @if(!$session_user_id)
                                                data-bs-toggle="modal"
                                                data-bs-target="#popup-login"
                                                @endif


                                                @if ($guruer->user_status == 0)
                                                style="pointer-events: none; color: white !important;"
                                                @endif

                                                data-item="{{ $profile_user_id }}"
                                                data-num="{{ $session_user_id }}">

                                                @if (getCountUserProfileFollowing($profile_user_id, $session_user_id) == 0)
                                                <i class="far fa-heart red-heart"></i> Add to Favorites
                                                @else
                                                <i class="fas fa-heart red-heart"></i> Remove from Favorites
                                                @endif
                                            </button>
                                            @php
                                            }
                                            @endphp


                                        </div>
                                        <!--<div class="extra_inf">
                        <b> 0 Booked in in 48 hours</b>
                        <p>Usually Responds in 2 hours</p>
						-->
                                    </div>


                                </div>







                            </div>



                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>


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
                                <a href="{{url('showLinkRequestForm')}}">Forgot Password?</a>
                            </div>


                            <div class="three-btn"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // JavaScript to handle the click event
    document.querySelectorAll(".related-product-img").forEach((image) => {
        image.addEventListener("click", function() {
            const mainImage = document.getElementById("main-product-image");
            mainImage.src = this.src; // Update the main product image source
        });
    });
</script>
<script>
    (function() {
        const quantityContainer = document.querySelector(".quantity");
        const minusBtn = quantityContainer.querySelector(".minus");
        const plusBtn = quantityContainer.querySelector(".plus");
        const inputBox = quantityContainer.querySelector(".input-box");
        updateButtonStates();
        quantityContainer.addEventListener("click", handleButtonClick);
        inputBox.addEventListener("input", handleQuantityChange);

        function updateButtonStates() {
            const value = parseInt(inputBox.value);
            minusBtn.disabled = value <= 1;
            plusBtn.disabled = value >= parseInt(inputBox.max);
        }

        function handleButtonClick(event) {
            if (event.target.classList.contains("minus")) {
                decreaseValue();
            } else if (event.target.classList.contains("plus")) {
                increaseValue();
            }
        }

        function decreaseValue() {
            let value = parseInt(inputBox.value);
            value = isNaN(value) ? 1 : Math.max(value - 1, 1);
            inputBox.value = value;
            updateButtonStates();
            handleQuantityChange();
        }

        function increaseValue() {
            let value = parseInt(inputBox.value);
            value = isNaN(value) ? 1 : Math.min(value + 1, parseInt(inputBox.max));
            inputBox.value = value;
            updateButtonStates();
            handleQuantityChange();
        }

        function handleQuantityChange() {
            let value = parseInt(inputBox.value);
            value = isNaN(value) ? 1 : value;
            // Execute your code here based on the updated quantity value
            console.log("Quantity changed:", value);
        }
    })();
</script>
<script>
    $(document).ready(function() {
        $("#course-slider").owlCarousel({
            items: 3,
            itemsDesktop: [1000, 1],
            itemsDesktopSmall: [979, 1],
            itemsTablet: [768, 1],
            pagination: false,
            navigation: true,
            navigationText: ["", ""],
            rewindNav: false,
            autoPlay: true
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: $(this).attr('action'), // Use form's action URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        $('#ajaxMessage')
                            .hide() // Ensure it's hidden before showing
                            .removeClass('alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message || 'Login successful!')
                            .fadeIn() // Smooth fade-in effect
                            .delay(1000) // Delay before fading out
                            .fadeOut();

                        // Redirect to the specified URL
                        setTimeout(() => {
                            window.location.href = response.redirect_url || '/';
                        }, 1500);
                    } else {
                        // Show error message
                        $('#ajaxMessage')
                            .hide()
                            .removeClass('alert-success')
                            .addClass('alert alert-danger')
                            .text(response.message || 'Invalid login credentials.')
                            .fadeIn() // Smooth fade-in effect
                            .delay(1000) // Delay before fading out
                            .fadeOut();
                    }
                },
                error: function(xhr) {
                    // Handle validation or server errors
                    let errorMsg = 'Login failed. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $('#ajaxMessage')
                        .hide()
                        .removeClass('alert-success')
                        .addClass('alert alert-danger')
                        .text(errorMsg)
                        .fadeIn() // Smooth fade-in effect
                        .delay(1000) // Delay before fading out
                        .fadeOut();
                }
            });
        });
    });
</script>






<script>
    $(document).ready(function() {
        var user_id, sender_user_id, status_msg, status_msg_old, button;

        $(".userfollow").click(function() {
            button = $(this);
            user_id = button.attr("data-item");
            sender_user_id = button.attr("data-num");

            status_msg_old = button.contents().filter(function() {
                return this.nodeType === Node.TEXT_NODE; // Only keep text nodes
            }).text().trim();

            // Determine the next status message

            var intermediate_old_mst = status_msg_old.includes("Add to Favorites");

            status_msg = intermediate_old_mst ?
                '<i class="fas fa-heart red-heart"></i> Remove from Favorites' :
                '<i class="far fa-heart red-heart"></i> Add to Favorites';

            status_msg_heart = intermediate_old_mst ?
                '<i class="fas fa-heart red-heart"></i><span style="display:none;"> Remove from Favorites </span>' :
                '<i class="far fa-heart red-heart"></i><span style="display:none;"> Add to Favorites </span>';





            // Show modal if removing from favorites, else execute directly
            if (status_msg_old.includes("Remove from Favorites")) {
                // Show Bootstrap modal
                $("#confirmationModal").modal('show');
            } else {
                executeProcess(user_id, sender_user_id, status_msg, status_msg_heart, false);
            }
        });

        // Handle modal confirmation
        $("#confirmYes").click(function() {
            $("#confirmationModal").modal('hide');
            executeProcess(user_id, sender_user_id, status_msg, status_msg_heart, true);
        });

        // Close modal on "No" button click
        $("#confirmNo").click(function() {
            $("#confirmationModal").modal('hide');
        });

        // Function to execute the process
        function executeProcess(user_id, sender_user_id, status_msg, status_msg_heart, isRemove) {
            if (user_id) {
                if (sender_user_id == user_id) {
                    alert("You cannot favorite yourself.");
                } else {
                    var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
                    var ajaxUrl = baseUrl + '/favorites_users_ajax'; // Construct the dynamic URL

                    $.ajax({
                        type: "POST",
                        url: ajaxUrl,
                        cache: false,
                        async: false,
                        data: {
                            sender: sender_user_id,
                            user: user_id,
                            _token: "{{ csrf_token() }}" // Include CSRF token
                        },
                        success: function(response) {
                            $(".follow-content" + user_id).html(status_msg);



                            $(".heart_follow-content" + user_id).html(status_msg_heart);





                            // Update the badge counter
                            var badge = $(".update_heart_ajax");
                            var currentCount = parseInt(badge.text()) || 0;

                            if (isRemove) {
                                badge.text(Math.max(currentCount - 1, 0)); // Decrease by 1, minimum 0
                            } else {
                                badge.text(currentCount + 1); // Increase by 1
                            }

                            // Refresh the wishlist dropdown
                            refreshWishlist();
                        },
                    });
                }
            } else {
                window.location.href = login_url;
            }
        }

        // Function to refresh the wishlist
        /*
        function refreshWishlist() {
            var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
            var refreshUrl = baseUrl + '/get-updated-wishlist'; // New endpoint to fetch updated data

            $.ajax({
                type: "GET",
                url: refreshUrl,
                cache: false,
                success: function (response) {
                    if (response.success) {
                        // Update the wishlist dropdown
                        var dropdownContent = '';
                        if (response.wishlist.length > 0) {
                            response.wishlist.slice(0, 4).forEach(function (item) {
                                dropdownContent += `
                                    <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="${item.profile_image}" alt="...">
                                            <div class="${item.online_status == 1 ? 'status-indicator bg-success' : ''}"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">${item.first_name}</div>
                                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                                        </div>
                                    </a>
                                `;
                            });
                            dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
                        } else {
                            dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
                        }

                        $(".chatnoti-open").html(`
                            <h6 class="dropdown-header">Wishlist</h6>
                            ${dropdownContent}
                        `);
                    }
                },
                error: function () {
                    console.error("Failed to refresh the wishlist.");
                }
            });
        }

        */

        function refreshWishlist() {
            var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
            var refreshUrl = baseUrl + '/get-updated-wishlist';

            $.ajax({
                type: "GET",
                url: refreshUrl,
                cache: false,
                success: function(response) {
                    if (response.success) {
                        var dropdownContent = '';
                        if (response.wishlist.length > 0) {
                            response.wishlist.slice(0, 4).forEach(function(item) {
                                dropdownContent += `
                                <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="${item.profile_image}" alt="...">
                                        <div class="${item.online_status == 1 ? 'status-indicator bg-success' : ''}"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">${item.first_name}</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                            `;
                            });
                            dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
                        } else {
                            dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
                        }

                        $(".chatnoti-open").html(`
                        <h6 class="dropdown-header">Wishlist</h6>
                        ${dropdownContent}
                    `);
                    } else {
                        // Handle case where response.success is false
                        $(".chatnoti-open").html(`
                        <h6 class="dropdown-header">Wishlist</h6>
                        <a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>
                    `);
                    }
                },
                error: function() {
                    console.error("Failed to refresh the wishlist.");
                }
            });
        }


    });
</script>

<!-- 000000000000000000000 -->


<script>
    $(document).ready(function() {
        $(".userfollow_heart").click(function() {
            var button = $(this);

            // Get the full HTML content of the button
            var status_msg_old = button.html().trim();
            console.log("Old Status Message (HTML):", status_msg_old);

            // Determine if the current action is to remove or add to favorites
            var isRemove = status_msg_old.includes("Remove from Favorites");

            // Update the status messages based on the current state
            var status_msg = isRemove ?
                '<i class="far fa-heart red-heart"></i> Add to Favorites' :
                '<i class="fas fa-heart red-heart"></i> Remove from Favorites';

            var status_msg_heart = isRemove ?
                '<i class="far fa-heart red-heart"></i><p style="display:none"> Add to Favorites </p>' :
                '<i class="fas fa-heart red-heart"></i><p style="display:none"> Remove from Favorites </p>';

            // Show confirmation modal if removing from favorites
            if (isRemove) {
                $("#confirmationModal").modal('show');

                // Handle confirmation (Yes) using event delegation
                $(document).on("click", "#confirmYes", function() {
                    $("#confirmationModal").modal('hide');
                    executeProcess_profile_top(button.attr("data-item"), button.attr("data-num"), status_msg, status_msg_heart, isRemove);
                });

                // Handle cancellation (No) using event delegation
                $(document).on("click", "#confirmNo", function() {
                    $("#confirmationModal").modal('hide');
                });

            } else {
                // Execute the process directly for adding to favorites
                executeProcess_profile_top(button.attr("data-item"), button.attr("data-num"), status_msg, status_msg_heart, isRemove);
            }
        });

        // Function to execute the process (you can modify this as per your requirement)
        function executeProcess_profile_top(user_id, sender_user_id, status_msg, status_msg_heart, isRemove) {
            if (user_id) {
                if (sender_user_id == user_id) {
                    alert("You cannot favorite yourself.");
                } else {
                    var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;

                    var ajaxUrl = baseUrl + '/favorites_users_ajax'; // Construct dynamic URL for favorites action

                    $.ajax({
                        type: "POST",
                        url: ajaxUrl,
                        cache: false,
                        data: {
                            sender: sender_user_id,
                            user: user_id,
                            _token: "{{ csrf_token() }}" // Include CSRF token
                        },
                        success: function(response) {
                            // Update the button content
                            $(".follow-content" + user_id).html(status_msg);
                            $(".heart_follow-content" + user_id).html(status_msg_heart);

                            // Update the badge counter
                            var badge = $(".update_heart_ajax");
                            var currentCount = parseInt(badge.text()) || 0;

                            if (isRemove) {
                                badge.text(Math.max(currentCount - 1, 0)); // Decrease by 1, minimum 0
                            } else {
                                badge.text(currentCount + 1); // Increase by 1
                            }

                            // Refresh the wishlist dropdown
                            refreshWishlist();
                        },
                        error: function() {
                            alert("Failed to process the request. Please try again.");
                        }
                    });
                }
            } else {
                window.location.href = login_url;
            }
        }

        // Function to refresh the wishlist (you can modify this as per your requirement)

        /*
        function refreshWishlist() {
            var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
            var refreshUrl = baseUrl + '/get-updated-wishlist'; // Construct dynamic URL for refreshing wishlist

            $.ajax({
                type: "GET",
                url: refreshUrl,
                cache: false,
                success: function (response) {
                    if (response.success) {
                        // Update the wishlist dropdown
                        var dropdownContent = '';
                        if (response.wishlist.length > 0) {
                            response.wishlist.slice(0, 4).forEach(function (item) {
                                dropdownContent += `
                                    <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="${item.profile_image}" alt="...">
                                            <div class="${item.online_status == 1 ? 'status-indicator bg-success' : ''}"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">${item.first_name}</div>
                                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                                        </div>
                                    </a>
                                `;
                            });
                            dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
                        } else {
                            dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
                        }

                        $(".chatnoti-open").html(`
                            <h6 class="dropdown-header">Wishlist</h6>
                            ${dropdownContent}
                        `);
                    } else {
                        console.error("Failed to refresh wishlist data.");
                    }
                },
                error: function () {
                    console.error("Failed to refresh the wishlist.");
                }
            });
        }
        */

        function refreshWishlist() {
            var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
            var refreshUrl = baseUrl + '/get-updated-wishlist';

            $.ajax({
                type: "GET",
                url: refreshUrl,
                cache: false,
                success: function(response) {
                    if (response.success) {
                        var dropdownContent = '';
                        if (response.wishlist.length > 0) {
                            response.wishlist.slice(0, 4).forEach(function(item) {
                                dropdownContent += `
                                <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="${item.profile_image}" alt="...">
                                        <div class="${item.online_status == 1 ? 'status-indicator bg-success' : ''}"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">${item.first_name}</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                            `;
                            });
                            dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
                        } else {
                            dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
                        }

                        $(".chatnoti-open").html(`
                        <h6 class="dropdown-header">Wishlist</h6>
                        ${dropdownContent}
                    `);
                    } else {
                        // Handle case where response.success is false
                        $(".chatnoti-open").html(`
                        <h6 class="dropdown-header">Wishlist</h6>
                        <a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>
                    `);
                    }
                },
                error: function() {
                    console.error("Failed to refresh the wishlist.");
                }
            });
        }



    });
</script>

<script>


    document.addEventListener("DOMContentLoaded", function () {
        const seeAllReviewsLink = document.getElementById("see-all-reviews");
        const hiddenReviews = document.querySelectorAll(".review-item.d-none, hr.d-none");

        seeAllReviewsLink.addEventListener("click", function (e) {
            e.preventDefault();

            hiddenReviews.forEach(review => {
                review.classList.remove("d-none");
            });

            // Hide the "See All Reviews" link after showing all reviews
            seeAllReviewsLink.style.display = "none";
        });
    });


    $('#submit-review').on('click', function() {
        // Fetch the rating value from the selected radio button
        const selectedRating = $('input[name="rating3"]:checked').val();

        // alert(selectedRating);
        // If no rating is selected, show an error message
        if (selectedRating < 0) {
            $("#message-box").show();
            $("#message-box").removeClass().addClass("alert alert-danger alert-dismissable");
            $("#message").text("Please select a rating.");
            return;
        }

        // Show a loader or disable the button to indicate submission
        $('#submit-review').prop('disabled', true).text('Submitting...');

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('save.user.review') }}", // Replace with your Laravel route name
            data: $("#review-rating-form").serialize(),
            success: function(data) {
                // Display the success or error message
                $("#message-box").show();
                $("#message-box").removeClass();

                if (data.ok) {
                    $("#message-box").addClass("alert alert-success alert-dismissable");
                    $("#message").text(data.message);

                    // Optionally, clear the form fields
                    $('#review-rating-form')[0].reset();
                } else {
                    $("#message-box").addClass("alert alert-danger alert-dismissable");
                    $("#message").text(data.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors from the server
                $("#message-box").show();
                $("#message-box").removeClass().addClass("alert alert-danger alert-dismissable");
                $("#message").text("An error occurred. Please try again later.");
            },
            complete: function() {
                // Re-enable the button and reset its text
                $('#submit-review').prop('disabled', false).text('Submit Review');
            }
        });
    });
</script>


@endsection