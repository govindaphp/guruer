
<div class="card-body msg_card_body">

    <input type="hidden" name="" id="reciver_id" value="{{$customer->id? $customer->id :'0'}}">
    @foreach ($chats as $chat)
        @if ($chat->sender_id != $merchent->id)
            <!-- User's (Sender) Message -->
            <div class="d-flex justify-content-start mb-4 side-left-chat">
                <div class="img_cont_msg">
                    <img src="{{$customer->profile_image==''? url('/public').'/front_assets/images/reviw1.png': url('/public').'/admin/uploads/user/'.$customer->profile_image}}" class="rounded-circle user_img" />
                </div>
                <div class="msg_cotainer">
                    @if ($chat->file_names)
                    <div class="drop-msg-receive">
                        @foreach(explode(',', $chat->file_names) as $file)
                        <img src="{{ url('/public/uploads/chat/' . $file) }}" alt="Chat Image" class="image_fluid" />
                        @endforeach
                    {{$chat->msg? $chat->msg :'' }}
                    </div>
                    <span class="msg_time_send">{{ \Carbon\Carbon::parse($chat->created_at)->format('h:i A') }}</span>
                    @else
                    <div class="drop-msg-receive">
                        {{$chat->msg}}
                    </div>
                    <span class="msg_time_receive">{{ \Carbon\Carbon::parse($chat->created_at)->format('h:i A') }}</span>
                  @endif
                </div>
            </div>

        @else
            <!-- Merchant's (Receiver) Message -->
            <div class="d-flex justify-content-end mb-4 side-right-chat">
                <div class="msg_cotainer_send">
                    @if ($chat->file_names)
                    <div class="drop-msg-send">
                        @foreach(explode(',', $chat->file_names) as $file)
                        <img src="{{ url('/public/uploads/chat/' . $file) }}" alt="Chat Image" class="image_fluid" />
                        @endforeach
                    {{$chat->msg? $chat->msg :'' }}
                    </div>
                    <span class="msg_time_send">{{ \Carbon\Carbon::parse($chat->created_at)->format('h:i A') }}</span>
                    @else
                    <div class="drop-msg-send">
                        {{$chat->msg}}
                    </div>
                    <span class="msg_time_send">{{ \Carbon\Carbon::parse($chat->created_at)->format('h:i A') }}</span>
                  @endif
                </div>
                <div class="img_cont_msg">
                    <img src="{{$merchent->profile_image==''? url('/public').'/front_assets/images/reviw1.png': url('/public').'/admin/uploads/user/'.$merchent->profile_image}}" class="rounded-circle user_img" />
                </div>
            </div>

        @endif

    @endforeach



</div>

