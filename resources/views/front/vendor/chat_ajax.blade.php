
                    <ul class="contacts">
                        @foreach ($allUsers as $user)
                        <li data-id="{{$user->id}}" data-name="{{$user->first_name}}" data-image ="{{$user->profile_image==''? url('/public').'/front_assets/images/reviw1.png': url('/public').'/admin/uploads/user/'.$user->profile_image}}" data-status="{{ $user->online_status }}"  class="merchant-item">
                            <div class="d-flex bd-highlight">
                                <div class="left-inner-value">
                                <div class="img_cont">

                                    <img src="{{$user->profile_image==''? url('/public').'/front_assets/images/reviw1.png': url('/public').'/admin/uploads/user/'.$user->profile_image}}" class="rounded-circle user_img" />
                                    @if ($user->online_status == 1)
                                    <span class="online_icon"></span>
                                    @else
                                    <span class="online_icon offline"></span>
                                    @endif
                                </div>

                                <div class="user_info">
                                    <span>{{$user->first_name}}</span>
                                    <p><i class="fa fa-camera" aria-hidden="true"></i> Photo</p>
                                </div>
                                </div>
                                <div class="time_zone">
                                    <span class="time">03:00 AM</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
