<div class="chat-message d-flex mb-3">

    <div class="message-avatar me-3">
      <input type="hidden" name="" id="reciver_id" value="{{$merchent->id? $merchent->id :'0'}}">
      <img src="{{$merchent->profile_image==''?'https://via.placeholder.com/40': url('/public').'/admin/uploads/user/'.$merchent->profile_image}}" alt="Receiver Avatar" class="rounded-circle">
      <p>{{$merchent->first_name}}</p>
    </div>
    @if (!$merchentChats->count() == 0)
    <div class="message-content">
      <div class="message-bubble bg-white p-2 rounded">
          @foreach ($merchentChats as $value)
          <input type="hidden" name="" id="reply_message_id" value="{{$value->id? $value->id :'0'}}">
          <p class="mb-0">{{$value->msg}}<br><span>{{ \Carbon\Carbon::parse($value->created_at)->format('h:i A') }}</span></p>
          @endforeach
      </div>
    </div>
    @endif
  </div>

  <!-- Example message from the sender -->
  <div class="chat-message d-flex justify-content-end mb-3">
    @if (!$userChats->count() == 0)
    <div class="message-content text-end">
      <div class="message-bubble bg-primary text-white p-2 rounded">
          @foreach ($userChats as $value)
          <p class="mb-0">{{$value->msg}}<br><span>{{ \Carbon\Carbon::parse($value->created_at)->format('h:i A') }}</span></p>
          @endforeach
      </div>
    </div>
    <div class="message-avatar ms-3">
      <img src="{{$customer->profile_image==''?'https://via.placeholder.com/40': url('/public').'/admin/uploads/user/'.$customer->profile_image}}" alt="Sender Avatar" class="rounded-circle">
      <p>{{$customer->first_name}}</p>
    </div>
    @endif
  </div>