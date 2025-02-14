@extends('front.layouts.layout')

@section('content')
<style>
    .chat {
        margin-top: auto;

        margin-bottom: auto;
    }

    ::-webkit-scrollbar {
        width: 20px;
    }

    .chat.message-chat-right {
        padding-right: 0px;
    }

    .message-chat-new {
        margin: 50px 0;
    }

    .card {
        height: 500px;

        background-color: #ffefef;

        overflow-y: auto;
    }

    span#action_menu_btn i.fas.fa-ellipsis-v {
        color: black;
    }

    .contacts_body {
        padding: 0.75rem 0 !important;

        white-space: nowrap;
    }

    .msg_card_body {
        overflow-y: auto;
    }
    .sidebar ui {
	list-style: none;
}
    .card-header {
	border-radius: 15px 15px 0 0 !important;
	border-bottom: 0 !important;
	background-color: #000;
	border-radius: 0px !important;
	padding: 12px;
	background-color: #000;
	border-radius: 0px !important;
	padding: 12px;
}
    .card-footer {
        border-radius: 0 0 15px 15px !important;

        border-top: 0 !important;
    }

    .container {
        align-content: center;
    }

    .search {
        border-radius: 15px 0 0 15px !important;

        background-color: #fff;

        border: 0 !important;

        color: white !important;
    }

    .search:focus {
        box-shadow: none !important;

        outline: 0px !important;
    }

    .type_msg {
        background-color: #fff;

        border: 0 !important;

        color: white !important;

        height: 60px !important;

        overflow-y: auto;
    }

    .type_msg:focus {
        box-shadow: none !important;

        outline: 0px !important;
    }

    .attach_btn {
        border-radius: 15px 0 0 15px !important;

        background-color: black !important;

        border: 0 !important;

        color: white !important;

        cursor: pointer;
    }

    .send_btn {
        border-radius: 0 15px 15px 0 !important;

        background-color: black !important;

        border: 0 !important;

        color: white !important;

        cursor: pointer;
    }

    textarea.form-control.type_msg {
        color: black !important;
    }
    .search_btn {
	border-radius: 0 15px 15px 0 !important;
	background-color: #fff;
	border: 0 !important;
	color: black;
	cursor: pointer;
	height: 36px;
	border-radius: 0px 50px 50px 0px !important;
}

    .contacts {
        list-style: none;

        padding: 0;
    }

    .contacts li {
        width: 100% !important;

        padding: 5px 25px;
    }

.chat.message-chat-left .contacts .active {
    background: #e9edef;
}

    .user_img {
        height: 40px;

        width: 40px;

        border: 1.5px solid #f5f6fa;
    }

    .user_img_msg {
        height: 40px;

        width: 40px;

        border: 1.5px solid #f5f6fa;
    }

    .img_cont {
        position: relative;

        height: 50px;

        width: 55px;
    }

    .img_cont_msg {
        height: 40px;

        width: 40px;
    }

    .online_icon {
        position: absolute;

        height: 10px;

        width: 10px;

        background-color: #4cd137;

        border-radius: 50%;

        bottom: 0.8em;

        right: 0.9em;

        border: 1.5px solid white;
    }

    .offline {
        background-color: #c23616 !important;
    }

    .user_info {
        margin-top: auto;

        margin-bottom: auto;

        margin-left: 0;
    }

    .user_info span {
        font-size: 20px;

        color: black;
    }

    .video_cam i.fas.fa-video {
        color: black;
    }

    .video_cam i.fas.fa-phone {
        color: black;
    }

    .user_info p {
        font-size: 11px;

        color: black;
    }

    .video_cam {
        margin-left: 50px;

        margin-top: 5px;
    }

    .video_cam span {
        color: white;

        font-size: 20px;

        cursor: pointer;

        margin-right: 20px;
    }

    .msg_cotainer {
        margin-top: auto;

        margin-bottom: auto;

        margin-left: 10px;

        border-radius: 25px;

        background-color: #fff;

        padding: 10px;

        position: relative;
    }
.msg_cotainer_send {
    margin-top: auto;
    margin-bottom: auto;
    margin-right: 10px;
    border-radius: 8px;
    background: #d3fed5;
    padding: 10px;
    position: relative;
    padding-bottom: 0px;
    padding-top: 0;
    padding-right: 30px;
    padding-top: 4px;
    padding-left: 18px;
    padding-bottom: 8px;
}
.chat.message-chat-right .card .card-footer {
    border-radius: 0px !important;
}
input.form-control.search {
    border-radius: 50px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 0px 1px 0 rgba(0, 0, 0, .12);
}

input#messageInput {
    border-radius: 50px;
}

.msg_cotainer_send:before {
    right: -3px;
    background-color: #cbfed7;
    position: absolute;
    top: 19px;
    display: block;
    width: 13px;
    height: 13px;
    content: " ";
    transform: rotate(29deg) skew(-35deg);
}
    .msg_time {
        position: relative;
        left: 8px;
        bottom: -33px;
        color: black;
        font-size: 12px;
    }

.msg_time_send {
    font-size: 12px;
    display: flex;
    justify-content: end;
    margin-top: 5px;
    color: gray;
}

    .msg_head {
        position: relative;
    }

    #action_menu_btn {
        position: absolute;

        right: 10px;

        top: 10px;

        color: white;

        cursor: pointer;

        font-size: 20px;
    }

    .action_menu {
        z-index: 1;

        position: absolute;

        padding: 15px 0;

        background-color: black;

        color: white;

        border-radius: 15px;

        top: 30px;

        right: 15px;

        display: none;
    }

    .action_menu ul {
        list-style: none;

        padding: 0;

        margin: 0;
    }

    .action_menu ul li {
        width: 100%;

        padding: 10px 15px;

        margin-bottom: 5px;
    }

    .action_menu ul li i {
        padding-right: 10px;
    }

    .action_menu ul li:hover {
        cursor: pointer;

        background-color: rgba(0, 0, 0, 0.2);
    }

    .chat.message-chat-left {
        padding: 0;
    }
    .chat.message-chat-left .online_icon {
        right: 0.9em;
    }
.chat.message-chat-left .input-group-text {
    padding: 0.65rem 0.75rem;
    border-radius: 0px 50px 50px 0px !important;
    background: #fff;
    color: black !important;
}
.chat.message-chat-left .card-header {
    background-color: #000;
    border-radius: 0px !important;
    padding: 12px;
}
    .card-footer .input-group {
        width: 100%;
    }

    .chat.message-chat-right .input-group-text {
        display: flex;

        align-items: center;

        padding: 1.375rem 0.75rem;

        font-size: 1rem;

        font-weight: 400;

        line-height: 1.5;

        color: var(--bs-body-color);

        text-align: center;

        white-space: nowrap;

        background-color: var(--bs-tertiary-bg);

        border: var(--bs-border-width) solid var(--bs-border-color);

        border-radius: var(--bs-border-radius);
    }

.sidebar ul.video-list-show .d-flex.bd-highlight {
    align-items: baseline;
}
    input.form-control.type_msg {
        color: black !important;
    }

.chat.message-chat-left input.form-control.search {
    color: black !important;
    border-radius: 50px 0px 0px 50px !important;
}

    .action_menu ul li:hover {
        color: #f58866;
    }

    .chat-box-left {
        display: flex;
        width: 50%;
        align-items: center;
    }

    .chat-box-right {
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    .search-container input.search-input {
        border: none;
        padding: 6px 28px;
        border-radius: 5px;
    }
    .search-container i.fa.fa-search {
        color: #000;
        margin-right: -28px;
        position: relative;
        z-index: 9;
    }

    .search-container input.search-input {
        border: none;
        padding: 6px 28px;
        border-radius: 5px;
        outline: none;
    }

    .search-container i.fa.fa-times {
        color: #000;
        position: absolute;
        right: 28px;
        margin-top: 9px;
        cursor: pointer;
    }
    .drop-msg-send i.fa.fa-angle-down {
        font-size: 21px;
    }
.drop-msg-send button.new-add-drop {
    position: relative;
    left: 100%;
    top: -8px;
    border: none;
    background: none;
    margin-left: 4px;
}
.drop-msg-send ul.dropdown-menu {
    position: absolute;
    right: -30px;
    top: 16px;
    line-height: 2;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 0;
    border: none;
}
.drop-msg-send .dropdown {
    height: 11px;
}
    .drop-msg-send ul.dropdown-menu li {
        padding-left: 11px;
        cursor: pointer;
    }
.drop-msg-send ul.dropdown-menu li:hover {
    background-color: #f58d6b;
    color: #fff;
}
.chat.message-chat-left .card-footer:last-child {
    border-radius: 0 0 var(--bs-card-inner-border-radius) var(--bs-card-inner-border-radius);
    border-radius: 0px !important;
    background: none !important;
}
.msg-three-icons i {
    background-color: #000;
    color: #fff;
    border-radius: 50px;
    cursor: pointer;
    font-size: 18px;
    width: 45px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}
    .msg-three-icons {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: 13px !important;
    }
    .msg-three-icons i:hover {
        background-color: #f58866;
    }
    #paperclip {
        cursor: pointer;
        font-size: 24px;
    }

    /* Style for the popup container */
    .popup {
        display: none;
        position: absolute;
        top: -190px;
        margin-left: 44px;
        border-radius: 8px;
        padding: 10px;
    }

    /* Style for popup icons */
    .popup .icon {
        display: flex;
        align-items: center;
        margin: 10px 0;
        cursor: pointer;
    }
    .popup .icon i {
        font-size: 18px;
        margin-right: 10px;
    }
    .side-right-chat {
        margin-bottom: 50px !important;
    }

    .left-inner-value {
        display: flex;
        gap: 11px;
        width: 100%;
    }

    .left-inner-value p {
        display: flex;
        align-items: center;
        gap: 4px;
    }
.chat.message-chat-left .contacts li {
    width: 100% !important;
    padding: 12px 25px;
    cursor: pointer;
    border-bottom: solid 1px #e9edef;
}
  .chat.message-chat-left .contacts li:hover {
    background-color: #e9edef;
}
button#sendMessageBtn {
    border: none;
    background: none;
    padding-left: 0px;
}

.message-chat-inner .card.contacts_card {
    background-color: #fff;
}
.card-footer {
    background: #e9edef !important;
}
.chat.message-chat-right .card {
    height: 500px;
    background-color: #fff !important;
    overflow-y: auto;
}
.chat.message-chat-right .user_info p {
    margin-bottom: 0px !important;
}
.chat-box-left .img_cont {
    height: auto;
}
.chat-box-left .online_icon {
    position: absolute;
    height: 10px;
    width: 10px;
    background-color: #4cd137;
    border-radius: 50%;
    bottom: 0.3em;
    right: 0.9em;
    border: 1.5px solid white;
}

div#imgSharefile {
    cursor: pointer;
}

div#modalBox .modal-content {
    background-color: #f1f1f1;
    border-radius: 0px;
    padding: 18px;
}
div#modalBox .modal-content span.close {
    text-align: right;
    font-size: 35px;
    cursor: pointer;
    font-weight: 700;
}
div#modalBox .modal-content span.close:hover {
    color: #8d8a8a;
}
div#modalBox img.inner-images {
    width: 381px;
    height: 350px;
    box-shadow: rgba(58, 53, 65, 0.2) 0px 5px 5px -3px, rgba(58, 53, 65, 0.14) 0px 8px 10px 1px, rgba(58, 53, 65, 0.12) 0px 3px 14px 2px;
    margin: auto;
    display: flex;
}

div#modalBox .modal-content  input#messageInput {
    border-radius: 11px;
    width: 55%;
    padding: 18px 13px;
    border: none;
    display: flex;
    justify-content: center;
    margin: auto;
    margin-top: 68px;
    box-shadow: rgba(0, 0, 0, -0.84) 0px 2px 5px 0px, rgba(0, 0, 0, 0.12) 0px 2px 10px 0px;
}

div#modalBox .modal-content input#messageInput:focus-visible {
    outline: none !important;
}


.message-container {
    position: relative;
}
.input_inner_part i.fas.fa-smile {
    position: absolute;
    left: calc(81% - 100px);
    bottom: 56px;
    background: none;
    color: gray;
    font-size: 20px;
}

.side-left-chat .img_cont_msg img {
    height: 40px;
    width: 40px;
    border-radius: 50px;
}
.side-left-chat .msg_cotainer {
    margin-top: auto;
    margin-bottom: auto;
    margin-right: 10px;
    border-radius: 8px;
    background: #e9edef;
    padding: 10px;
    position: relative;
    padding-bottom: 0px;
    padding-top: 0;
    padding-top: 4px;
    padding-left: 18px;
    padding-bottom: 8px;
}

.side-left-chat .msg_cotainer span {
    padding-left: 11px;
}

.msg_cotainer:after {
    left: -3px;
    background-color: #e9edef;
    position: absolute;
    top: 19px;
    display: block;
    width: 13px;
    height: 13px;
    content: " ";
    transform: rotate(29deg) skew(-35deg);
}


.side-left-chat i.fa.fa-angle-down {
    font-size: 21px;
}
.side-left-chat button.new-add-drop {
    position: relative;
    right: 20px;
    top: -8px;
    border: none;
    background: none;
    margin-left: 4px;
}

.msg_cotainer .dropdown {
    height: 11px;
}
.left-sidebar-video {
    display: flex;
    gap: 0px;
    width: 100%;
    padding-left: 10px;
}
.container-fluid.page-body-wrapper.vendor-dashboard {
    padding-right: 0px;
}
img.video-loader {
    width: 100%;
}

.sidebar.sidefix {
    display: flex;
    flex-direction: column;
    width: 100%;
}
@media only screen and (max-width: 767px) {
        .message-chat-new {
            margin: 0px 0px;

            padding: 19px;
        }

        .chat.message-chat-right {
            padding-right: 0px;

            margin-top: 14px;
        }

        .contacts_card .card-header {
            margin-top: 11px;

            margin-left: 11px;
        }

        .chat.message-chat-right .d-flex.justify-content-start.mb-4 {
            margin-bottom: 45px !important;
        }

        .chat.message-chat-right .d-flex.justify-content-end.mb-4 {
            margin-bottom: 45px !important;
        }

        .user_info p {
            font-size: 12px;

            color: black;
        }

        .row.browse-content {
            padding-left: 22px;
        }

        .msg_time {
            bottom: -22px;
        }

        .msg_time_send {
            bottom: -20px;
        }

        .card-body.contacts_body .contacts li {
            margin-bottom: 9px;
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .message-chat-inner {
            margin: 0px;
        }

        .contacts li {
            width: 100% !important;

            padding: 5px 8px;
        }

        .chat.message-chat-left .d-flex.bd-highlight {
            align-items: center;

            gap: 11px;
        }

        .chat.message-chat-left .card-header {
            padding: 11px 0px;

            margin-left: 9px;
        }

        .message-chat-new {
            margin: 30px 0;
        }
    }
</style>

<div class="banner-tailors">
  <div class="container browse-tailors">
    <div class="row browse-content">
      <h1 class="text-white">Video Chat Room</h1>
    </div>
  </div>
</div>

<div class="container-fluid page-body-wrapper vendor-dashboard d-flex pt-5 pb-5"> 
  <!-- Sidebar -->
  <input type="hidden" name="bbbchaturl" id="bbbchaturl" value="{{url('chatRoom')}}?meetingId={{$meeting_id}}">
  <input type="hidden" name="cuserId" id="cuserId" value="{{$user_id}}">

  <div class="sidebar sidefix">
   <div class="status-text">
    <h5>All Customers</h5>
    <div class="status online" style="font-size:18px;">Join Request</div>
    </div>
                  <div class="card-header video-card-input">
                    <div class="input-group">
                        <input type="text" placeholder="Search..." id="keyword-text" name="keyword-text" class="form-control search" />
                        <div class="input-group-prepend">
                            <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>



<div id="results-container">


      <ul class="video-list-show">
          @foreach ($allCustomers as $user)
          <li data-id="{{$user->id}}" data-name="{{$user->first_name}}" data-image ="{{$user->profile_image==''? url('/public').'/front_assets/images/reviw1.png': url('/public').'/admin/uploads/user/'.$user->profile_image}}" data-status="{{ $user->online_status }}"  class="merchant-item">
              <div class="d-flex bd-highlight">
               <div class="left-sidebar-video">
                  <div class="img_cont">
                      <img src="{{$user->profile_image==''? url('/public').'/front_assets/images/reviw1.png': url('/public').'/admin/uploads/user/'.$user->profile_image}}" class="rounded-circle user_img" />
                      @if ($user->online_status == 1)
                      <span class="online_icon"></span>
                      @else
                      <span class="online_icon offline"></span>
                      @endif
                  </div>
                  <div class="user_info">
                      <span>{{ \Illuminate\Support\Str::limit($user->first_name, 15, '') }}</span><i class="fa fa-check" aria-hidden="true" id="check-icon{{ $user->id }}" style="display:none"></i>

                      <p><i class="fa fa-camera" aria-hidden="true"></i> Photo</p>
                  </div>
                  </div> 
                  <div class="time_zone">
                      <!-- <span class="time">03:00 AM</span> -->
                  </div>
              </div>
          </li>
          @endforeach
      </ul>
</div>
    </div>
<!-- list of users -->


  <!-- Chat Container -->
  <div class="col-md-9">
   
  <div class="container" id="bbbchat">

    <?php //echo $start_url; ?>

    <iframe src="<?php echo $start_url; ?>" width="100%" height="600px" style="border:none;">
     
    </iframe>    

</div>


  </div>
</div>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>

$(document).ready(function() {
  $('div[data-test="userListContent"]').css('display', 'none');
});

var currentUserId = $('#auth_id').val();

  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('7f5861c5f5323d85bf00', {
    cluster: 'ap2'
  });

  var channel = pusher.subscribe('Laravel-Chat');
  channel.bind('my-event', function(data) {
    var userData = data.user;
    const messageId = userData.msg_id; 

    var messageHtml;

    if (userData.sender_id == currentUserId ) {
    // Append the message to the sender container
    messageHtml =`
        <div class="d-flex justify-content-end mb-3" id="${messageId}">
        <div class="message-content text-end">
            <div class="message-bubble bg-primary text-white p-2 rounded">
                <p>${userData.msg}<br><span>${userData.time}</span></p>
            </div>
        </div>
        <div class="message-avatar ms-3">
            <img src="${userData.profile_image == null 
                ? window.location.origin +'/public/front_assets/images/reviw1.png' 
                : window.location.origin + '/public/admin/uploads/user/' + userData.profile_image}" 
            alt="Sender Avatar" class="rounded-circle">
            <p>${userData.name}</p>
        </div>
    </div>`;
    
        if ($(`#${messageId}`).length > 0) {
            $(`#${messageId}`).replaceWith(messageHtml);
        }

  } else {
    // Append the message to the receiver container
    messageHtml =
    `<div class="chat-message d-flex mb-3">
    <div class="message-avatar ms-3">
        <img src="${userData.profile_image == null
            ? window.location.origin +'/public/front_assets/images/reviw1.png' 
            : window.location.origin +'/public/admin/uploads/user/' + userData.profile_image}" 
          alt="Sender Avatar" class="rounded-circle">
        <p>${userData.name}</p>
    </div>
      <div class="message-content">
        <div class="message-bubble bg-white p-2 rounded">
          <p>${userData.msg}<br><span>${userData.time}</span></p>
        </div>
      </div>
      </div>`;
      
       $('#chat_div').append(messageHtml);
  }

    

// Optionally scroll to the bottom of the chat for new messages
  $('#chat_div').animate({
        scrollTop: $('#chat_div')[0].scrollHeight
    }, 500);

  });
</script>

<script>


  $(document).on('click', '.merchant-item', function() {
    const merchantId = $(this).data('id'); // Get the data-id attribute
    var vchaturl = $('#bbbchaturl').val();
    var cuserId = $('#cuserId').val();

    var my_msg = vchaturl;
    var sender_id = cuserId ;
    var reciver_id = merchantId;
    var reply_message_id = '';//$('#reply_message_id').val();

    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    $.ajax({
        url: "{{url('/vendorMessageSubmit')}}", // Replace with your backend route
        type: 'POST', 
        datatype: "json",// or 'GET' depending on your requirement
        data: {
          my_msg: my_msg,
          sender_id: sender_id,
          reciver_id: reciver_id,
          reply_message_id: reply_message_id,
          userTimeZone: userTimeZone,
            _token: '{{ csrf_token() }}' // Include CSRF token for security if using Laravel
        },
        success: function(response) {
            $('#check-icon' + reciver_id).show();
          //alert('Request send successfully!');
        },
        error: function(xhr) {
            // Handle error
            console.error('Error:', xhr.responseText);
        }
    });



});

$(document).on('keypress', '#my_msg', function(event) {
		if (event.which == 13) {
			var message = $('#my_msg').val();
			//var  message = $("#message").val();
			if ($.trim(message) == '') {
				$('#error_message').show();
				return false;
			} else {
				event.preventDefault();
				myFunction();
			}
		}
});


</script>

<script>
  function myFunction() {
    var my_msg = $('#my_msg').val();
    var sender_id = $('#auth_id').val();
    var reciver_id = $('#reciver_id').val();
    var reply_message_id = $('#reply_message_id').val();

    if ($.trim(my_msg) == '') {
				$('#error_message').show();
				return false;
			} else {
        $('#error_message').hide();
		}

    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    $.ajax({
        url: "{{url('/vendorMessageSubmit')}}", // Replace with your backend route
        type: 'POST', 
        datatype: "json",// or 'GET' depending on your requirement
        data: {
          my_msg: my_msg,
          sender_id: sender_id,
          reciver_id: reciver_id,
          reply_message_id: reply_message_id,
          userTimeZone: userTimeZone,
            _token: '{{ csrf_token() }}' // Include CSRF token for security if using Laravel
        },
        success: function(response) {
          $('#chat_div').append(response.html);
          $('#my_msg').val('');
        },
        error: function(xhr) {
            // Handle error
            console.error('Error:', xhr.responseText);
        }
    });

    
  }
</script>




<script>

function fetchFilteredResults() {  
    const keywordTextValue = $('#keyword-text').val();

            $('#results-container').html("<div class='text-center' style='display:block'><img class='video-loader' src='{{ asset('public/admin/assets/images/lg.gif') }}' alt='Loading...'></div>");


            $.ajax({
                url: "{{ route('ajaxvideoresults') }}", // Laravel route for loading results
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security                    
                    keyword: keywordTextValue,                    
                },
                success: function (response) {
                    // Update the results container with the new data
                    $('#results-container').html(response);

                    const ulElement = $('#results-container ul');
                    if (ulElement.find('li').length === 0) {
                        $('#results-container').html("<div class='sidefixnext'><p class='text-center no-data-text'>No data found</p></div>");
                    }
                    
                },
                error: function () {
                    alert('An error occurred while fetching results.');
                },
                complete: function () {
                    // Hide the loading spinner once the request is complete
                    //$('#loading-spinner').hide();
                }
            });


        }
     $('#keyword-text').on('change keyup', fetchFilteredResults);
</script>  




<script>

$(document).ready(function() { 
window.addEventListener('message', function(event) { alert(event);
    // Check if the message is from the correct origin
    if (event.origin === 'https://biggerbluebutton.com/') {
        if (event.data === 'iframe-loaded') {
            // Now interact with the iframe
            var iframe = document.querySelector('iframe');
            var iframeDoc = iframe.contentWindow.document;
            var userList = iframeDoc.querySelector('[data-test="userListContent"]');
            if (userList) {
                userList.style.display = 'none';  // Hide the user list
            }
        }
        else{  alert('not loaded'); }
    }

  })
});



</script>


@endsection
