<div>
    <ul class="video-list-show">
        @forelse ($allUsers as $user)
            <li data-id="{{ $user->id }}" 
                data-name="{{ $user->first_name }}" 
                data-image="{{ $user->profile_image == '' ? url('/public').'/front_assets/images/reviw1.png' : url('/public').'/admin/uploads/user/'.$user->profile_image }}" 
                data-status="{{ $user->online_status }}" 
                class="merchant-item">
                <div class="d-flex bd-highlight">
                    <div class="left-sidebar-video">
                        <div class="img_cont">
                            <img src="{{ $user->profile_image == '' ? url('/public').'/front_assets/images/reviw1.png' : url('/public').'/admin/uploads/user/'.$user->profile_image }}" class="rounded-circle user_img" />
                            @if ($user->online_status == 1)
                                <span class="online_icon"></span>
                            @else
                                <span class="online_icon offline"></span>
                            @endif
                        </div>
                        <div class="user_info">
                            <span>{{ \Illuminate\Support\Str::limit($user->first_name, 15, '') }}</span> <i class="fa fa-check" aria-hidden="true" id="check-icon{{ $user->id }}" style="display:none"></i>
                            <p><i class="fa fa-camera" aria-hidden="true"></i> Photo</p>
                        </div>
                    </div>
                    <div class="time_zone">
                        <!-- <span class="time">03:00 AM</span> -->
                    </div>
                </div>
            </li>
        @empty
            <p class="text-center no-data-text">No data found11111</p>
        @endforelse
    </ul>
</div>
