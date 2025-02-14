@extends('front.layouts.layout')

@section('content')
<style>
  .chat-container {
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
  }
  .chat-header {
    border-bottom: 1px solid #ddd;
  }
  .chat-body {
    flex: 1;
  }
  .chat-footer {
    border-top: 1px solid #ddd;
  }
  .message-bubble {
    max-width: 100%;
  }
  input.form-control.me-2 {
    box-shadow: none !important;
}
  .message-avatar img {
    width: 40px;
    height: 40px;
  }
  /* Sidebar styling */
  .sidebar {
    width: 250px;
    background-color: #f8f9fa;
    border-right: 1px solid #ddd;
    padding: 20px;
  }
  .sidebar .status {
    font-size: 14px;
    color: #888;
  }
  .sidebar .status.online {
    color: green;
  }
  .sidebar .status.offline {
    color: red;
  }


</style>


<div class="container-fluid page-body-wrapper vendor-dashboard">
<div class="row chat-row">
<div class="col-md-3 p-0">
  <!-- Sidebar -->
  <div class="sidebar chat--box">
    <h5>All Users</h5>
    <ul class="people">
      @foreach ($allUsers as $user)
      <li data-id="{{$user->id}}" class="merchant-item person">   
      <img class="rounded-circle" src="{{ url('/public') }}/front_assets/images/undraw_profile_1.svg"
      <span class="name">{{$user->first_name}}</span>
                    <span class="time">2:09 PM</span>
                    <span class="preview">I was wondering...</span>  
                    
        @if ($user->online_status == 1)
        <!--<i class="fa fa-circle text-success" aria-hidden="true" title="Online"></i> -->
        @endif
      </li>
      @endforeach
    </ul>

    <!-- You can add more information about the user here -->
  </div>
</div>



  <!-- Chat Container -->
  <div class="col-md-9 d-flex justify-content-center align-items-end right_chat_col">
    <h3 id="chat_head"><span>Please select a user</span> </h3>
    <form action="#" id="chat_form" method="POST" enctype="multipart/form-data">
    <div class="chat-container chat-infos" id="chat_container" style="display: none">

    <div class="conversation-start">
                    <span>Today, 5:38 PM</span>
                </div>
    
      <div class="chat-body p-3 bg-light" style="height: 400px; overflow-y: scroll;" id="chat_div">
        <!-- Example message from the receiver -->
        
      </div>

      <div class="chat-footer d-flex align-items-center p-3 bg-white">

        <input type="hidden" name="auth_id" id="auth_id" value="{{auth('user')->id()? auth('user')->id() :'0'}}">
        <input type="text" id="my_msg" class="form-control me-2" placeholder="Type a message..." >
        <button type="submit" class="btn btn-primary me-2">
          <i class="bi bi-send"></i> Send
        </button>
        <label class="btn btn-secondary">
          <i class="bi bi-paperclip"></i>
          <input type="file" name="file" id="my_file" hidden>
        </label>
      </div>
      <div class="center-message text-center">
        <p id="error_message" class="text-danger" style="display:none;">Please enter a message!</p>
      </div>
    </div>
  </form>
  </div>
  </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>

  // Enable pusher logging - don't include this in production

  var currentUserId = $('#auth_id').val();


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
    messageHtml= `
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
    messageHtml =`
     <div class="chat-message d-flex mb-3">
      <div class="message-avatar ms-3">
        <img src="${userData.profile_image == null
            ? window.location.origin +'/public/front_assets/images/reviw1.png' 
            : window.location.origin +'/public/admin/uploads/user/' + userData.profile_image}" 
          alt="Sender Avatar" class="rounded-circle">
        <p>${userData.name}</p>
      </div>
      <div class="message-content">
        <div class="message-bubble bg-white p-2 rounded">
              ${userData.msg_image 
                ? `<img src="${window.location.origin + '/public/uploads/chat/' + userData.msg_image}" alt="" class="rounded-circle">
                  <br><span class="timestamp">${userData.time}</span>`
                : `<p>${userData.msg}<br><span class="timestamp">${userData.time}</span></p>`
              }
        </div>
      </div>
      </div>`;
      
      $('#chat_div').append(messageHtml);
  }



// Append the new element to the container
  $('#chat_div').animate({
        scrollTop: $('#chat_div')[0].scrollHeight
    }, 500);

  });
</script>



<script>

  $(document).on('click', '.merchant-item', function() {
    const userId = $(this).data('id'); // Get the data-id attribute
    // Perform AJAX request

    $.ajax({
        url: "{{url('/getUser')}}", // Replace with your backend route
        type: 'POST', 
        datatype: "html",// or 'GET' depending on your requirement
        data: {
            id: userId,
            _token: '{{ csrf_token() }}' // Include CSRF token for security if using Laravel
        },
        success: function(response) {
          $('#chat_container').show();
          $('#chat_head').hide();
          $('#chat_div').html(response)
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
			}
		}
});

$('#chat_form').on('submit', function(event) {
  event.preventDefault();

  var my_msg = $('#my_msg').val();
  var sender_id = $('#auth_id').val();
  var reciver_id = $('#reciver_id').val();
  var photo = $('#my_file').prop('files')[0]; 
  var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

  if ($.trim(my_msg) == '' && !photo) {
				$('#error_message').show();
				return false;
			} else {
        $('#error_message').hide();
		}

  var formData = new FormData();
  formData.append('my_msg', my_msg);
  formData.append('sender_id', sender_id);
  formData.append('reciver_id', reciver_id);
  formData.append('userTimeZone', userTimeZone);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
  if (photo) {
    formData.append('photo', photo);
  }


  $.ajax({
        url: "{{url('/merchentMessageSubmit')}}", 
        type: 'POST', 
        datatype: "json",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          $('#my_msg').val('');
          $('#chat_div').append(response.html);
          $('#chat_div').animate({
          scrollTop: $('#chat_div')[0].scrollHeight
          }, 500);
          
        },
        error: function(xhr) {
            // Handle error
            console.error('Error:', xhr.responseText);
        }
    });

});


</script>



@endsection
