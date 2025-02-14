<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\ChatSharedFile;
use App\Events\MessageSent;
use App\Models\ChatStatus;
use Validator,DB,Mail;
use Carbon\Carbon;

class MerchentChatController extends Controller
{
    //



    public function conversation(Request $request){
		$data['customer'] = User::where('id', $request->id)->first();
		$data['merchent'] = User::where('id', auth('user')->id())->first();

		$data['userChats'] = DB::table('chat_msg as c')
		->select('c.id as chat_id', 'c.sender_id', 'c.msg','c.created_at','c.is_share_file', 'c.is_link','c.is_meet_in_classroom','c.file_type','c.mime_type','c.is_reply','c.reply_message_id','c.reply_share_message_id','c.is_forward','c.track_duration','c.created_at','users.id','users.profile_image','users.first_name as sender_name','chat_msg_status.receiver_id', DB::raw('GROUP_CONCAT(chat_shared_file.file_name) as file_names'))
		->Join('users', 'users.id', '=', 'c.sender_id')
		->Join('chat_msg_status', 'chat_msg_status.chat_msg_id', '=' , 'c.id')
		->leftJoin('chat_shared_file', 'chat_shared_file.chat_id', '=', 'c.id')
		->where('c.sender_id', '=', $data['customer']->id)
		->where('chat_msg_status.receiver_id', '=', $data['merchent']->id) 
        ->groupBy(
            'c.id',
            'c.sender_id',
            'c.msg',
            'c.created_at',
            'c.is_share_file',
            'c.is_link',
            'c.is_meet_in_classroom',
            'c.file_type',
            'c.mime_type',
            'c.is_reply',
            'c.reply_message_id',
            'c.reply_share_message_id',
            'c.is_forward',
            'c.track_duration',
            'users.id',
            'users.profile_image',
            'users.first_name',
            'chat_msg_status.receiver_id'
        )
		->orderBy('chat_id', 'DESC')
		->limit(10)
		->get()
		->reverse();

		$data['merchentChats'] = DB::table('chat_msg as c')
		->select('c.id as chat_id', 'c.sender_id', 'c.msg','c.created_at','c.is_share_file', 'c.is_link','c.is_meet_in_classroom','c.file_type','c.mime_type','c.is_reply','c.reply_message_id','c.reply_share_message_id','c.is_forward','c.track_duration','c.created_at','users.id','users.profile_image','users.first_name as sender_name','chat_msg_status.receiver_id', DB::raw('GROUP_CONCAT(chat_shared_file.file_name) as file_names'))
		->Join('users', 'users.id', '=', 'c.sender_id')
		->Join('chat_msg_status', 'chat_msg_status.chat_msg_id', '=' , 'c.id')
		->leftJoin('chat_shared_file', 'chat_shared_file.chat_id', '=', 'c.id')
		->where('c.sender_id', '=', $data['merchent']->id)
		->where('chat_msg_status.receiver_id', '=', $data['customer']->id) // take data as customer receiver_id
        ->groupBy(
            'c.id',
            'c.sender_id',
            'c.msg',
            'c.created_at',
            'c.is_share_file',
            'c.is_link',
            'c.is_meet_in_classroom',
            'c.file_type',
            'c.mime_type',
            'c.is_reply',
            'c.reply_message_id',
            'c.reply_share_message_id',
            'c.is_forward',
            'c.track_duration',
            'users.id',
            'users.profile_image',
            'users.first_name',
            'chat_msg_status.receiver_id'
        )
		->orderBy('chat_id', 'DESC')
		->limit(10)
		->get()
		->reverse();

		$mergedChats = $data['merchentChats']->merge($data['userChats'])->sortBy('created_at');
		$data['chats'] = $mergedChats;

		return view('front/vendor/conversation',$data);
	}

	public function merchentMessageSubmit(Request $request){

		$data['customer'] = User::where('id', $request->reciver_id)->first();
		$data['merchent'] = User::where('id', auth('user')->id())->first();

		$user = $data['customer'];
		$merchent = $data['merchent'];

        $messageInput = $request->messageInput;
        if(!empty( $messageInput)){
            $my_msg = $messageInput;
        }else{
            $my_msg = $request->my_msg;
        }


		$sender_id = $request->sender_id;
		$reciver_id = (int) $request->reciver_id;
		$userTimeZone  = $request->userTimeZone;
		$update_message_id = $request->input('update_message_id');
		$reply_message_id = $request->input('reply_message_id');

		$currentDateTime = Carbon::now($userTimeZone)->format('Y-m-d H:i:s');

		$newChat = new ChatMessage();
		$newChat->sender_id = $sender_id;
		$newChat->msg		= $my_msg;
		$newChat->status	= '1';
		$newChat->created_at = $currentDateTime;
		$newChat->save();
		$newChat_id = $newChat->id;

		$newChatStatus = new ChatStatus();
		$newChatStatus->receiver_id = $reciver_id;
		$newChatStatus->chat_msg_id = $newChat_id;
		$newChatStatus->is_read = 0;
		$newChatStatus->status = 0;
		$newChatStatus->chat_msg_type = 1;
		$newChatStatus->created_at = $currentDateTime;
		$newChatStatus->save();
		$newChatStatus_id = $newChatStatus->id;

		$imageNames = [];

		if($request->hasFile('photos')){
            foreach ($request->file('photos') as $image) {
                $imageName = "cus" . uniqid() . '.' . $image->extension();
                $image->move(public_path('/uploads/chat'), $imageName);
                $newChatSharedFile = new ChatSharedFile();
                $newChatSharedFile->chat_id   = $newChat_id;
                $newChatSharedFile->file_name = $imageName;
                $newChatSharedFile->file_type = $request->file_type;
                $newChatSharedFile->is_active_file = '1';
                $newChatSharedFile->save();
                $imageNames[] = $imageName;
            }
		}



		$time = Carbon::now($userTimeZone)->format('h:i A');

		$data = [
			'msg_id' => $newChat_id,
			'msg' =>$my_msg,
			'newChat_id' =>$newChat_id,
			'sender_id' =>$sender_id,
			'profile_image' => $data['merchent']->profile_image,
			'name' => $data['merchent']->first_name,
			'time' => $time,
			'msg_image' => $imageNames,
		];

		event(new MessageSent($data));


        $grpmsgs = DB::table('chat_msg as c')
        ->select('c.id as chat_id', 'c.sender_id', 'c.msg', 'c.created_at', 'c.is_share_file', 'c.is_link', 'c.is_meet_in_classroom', 'c.file_type', 'c.mime_type', 'c.is_reply', 'c.reply_message_id', 'c.reply_share_message_id', 'c.is_forward', 'c.track_duration', 'users.id', 'users.profile_image', 'users.first_name as sender_name')
        ->join('users', 'users.id', '=', 'c.sender_id')
        ->join('chat_msg_status', 'chat_msg_status.chat_msg_id', '=', 'c.id')
        ->leftJoin('chat_shared_file', 'chat_shared_file.chat_id', '=', 'c.id')
        ->where('chat_msg_status.receiver_id', '=', $reciver_id)
        ->orderBy('chat_id', 'DESC')
        ->first();  // Using first() as we are fetching a single message

    // Fetch all the shared files associated with the chat
    $sharedFiles = DB::table('chat_shared_file')
        ->where('chat_id', '=', $grpmsgs->chat_id)
        ->get();

        $html = '<div class="d-flex justify-content-end mb-4 side-right-chat" >
        <div class="msg_cotainer_send">';

        if (!empty($grpmsgs)) {
        // Check if the message has files associated with it
        if ($sharedFiles->isNotEmpty()) {
            $html .= '<div class="drop-msg-send">';
            $imageCount = count($sharedFiles);
            $imageElements = '';
            foreach ($sharedFiles as $file) {
                $imageElements .= '<img src="' . url('/public/uploads/chat/' . $file->file_name) . '" alt="Sender Avatar" class="image_fluid">';
            }

            if($imageCount >= 2){

                $moreImagesOverlay = $imageCount > 2 ? '<div class="more-overlay">+' . ($imageCount - 2) . '</div>' : '';

                $html .= '<div class="image-group whatsapp-show-img">';
                $html .= $imageElements;
                $html .= $moreImagesOverlay;
                $html .= '</div>';
                $html .= $messageInput ? $messageInput : '';
                $html .= '</div>';

            }else{
                $html .= $imageElements;
                $html .= $messageInput ? $messageInput : '';
                $html .= '</div>';
            }

        } else {
            // If no files, show the message text
            $html .= '<div class="drop-msg-send">' . $grpmsgs->msg . '</div>';
        }

        // Add the message time
        $html .= '<span class="msg_time_send">' . \Carbon\Carbon::parse($grpmsgs->created_at)->format('h:i A') . '</span>';
        }

        $html .= '</div>
            <div class="img_cont_msg">
                <img src="' . (empty($merchent->profile_image) ?  url('/public').'/front_assets/images/reviw1.png' : url('/public/admin/uploads/user/' . $merchent->profile_image)) . '" alt="Sender Avatar" class="rounded-circle user_img">
            </div>
        </div>';

		return response()->json([
			'status' => 'success',
			'html' => $html
		]);

	}

}
