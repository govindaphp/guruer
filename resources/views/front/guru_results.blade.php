<div class="all-home-page" id="results-container">



  <div class="container rst_show">

                <div class="row">

                    <div class="col-md-12">

                        <div class="section-header mb-1">

                            <h2 class="section-title"></h2>

                        </div>        

                    </div>

                </div>  







                <div class="block-cgr">

                        <div class="row result-container">

                            <div class="pagination-container item_shows">

                            <ul>

							@php
								$user = Auth::guard("user")->user();
							@endphp    
                            @foreach($allUsers as $key => $value)

                            <li class="outerli">

							<div class="mylists">

										<div class="col-12 col-lg-8 col-md-6 search-item first">

											<div class="card border-light mb-4 item_list img-list-show">

												<div class="row no-gutters align-items-center">

													<div class="col-md-4 col-lg-6 col-xl-4 item_list_left">

														<div class="image-extra">

															<div class="options_cust">

																<a href="#"><span class="{{ $value->online_status == 1 ? 'on_line' : 'off_line' }}"></span></a>

															</div>



<div class="heart-icons">
@php                                                            
	$session_user_id = $user->id ?? null; 
	$profile_user_id = $value->id ?? null; // Ensure $guruer->id is handled correctly
@endphp										
											
@php
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

																<span class="star fas fa-star text-warning"></span>

																<span class="star fas fa-star text-warning"></span>

																<span class="star fas fa-star text-warning"></span>

																<span class="star fas fa-star text-warning"></span>

																<span class="star fas fa-star text-warning"></span> 

																<span class="badge badge-pill badge-primary ml-2">5.0</span>

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

										<div class="col-12 col-lg-4 col-md-6 video-show ">

											<div class="card">

												<div class="ratio ratio-16x9">

												  <!-- <iframe width="1424" height="652" src="https://www.youtube.com/embed/NAMvdbS4lk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe> -->

													<!-- @if(!empty($value->video_data))
                                                        <iframe  width="1424"  height="652" 
                                                            src="{{ $value->video_data }}" 
                                                            title="YouTube video player" 
                                                            frameborder="0" 
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                            allowfullscreen>
                                                        </iframe>
                                                    @else
                                                        <p class="text-center">No video available</p>
                                                    @endif -->
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

										</div>

                                    </li>

								

									

                            @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

        </div>

        </div>



