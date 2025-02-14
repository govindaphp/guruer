@extends('front.layouts.layout') @section('content')

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

    .card-header {
        border-radius: 15px 15px 0 0 !important;

        border-bottom: 0 !important;
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

        background: none !important;

        border: 0 !important;

        color: white !important;

        cursor: pointer;
    }

    textarea.form-control.type_msg {
        color: black !important;
    }

    .search_btn {
        border-radius: 0 15px 15px 0 !important;

        background-color: black;

        border: 0 !important;

        color: white !important;

        cursor: pointer;
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

input#my_msg {
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

        padding: 0;

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

    .d-flex.bd-highlight {
        align-items: center;
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

    .time_zone {
        padding-left: 64px;
        font-size: 12px;
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
    margin-bottom: 30px !important;
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
    margin: auto;
    display: flex;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
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
.input_inner_part i.fa.fa-smile-o {
    position: absolute;
    left: calc(79% - 95px);
    background: none;
    color: gray;
    font-size: 20px;
    margin-bottom: 8px;
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

.side-left-chat span.msg_time_receive {
    font-size: 12px;
    display: flex;
    justify-content: flex-start;
    margin-top: 5px;
    color: gray;
}
.message-container.inner-msg button.send-btn {
    border: none;
}
.inner-msg .input_inner_part {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    box-sizing: border-box;
    margin-left: 40px;
}

.inner-msg .mesg-send-inner {
    display: flex;
    align-items: end;
    gap: 10px;
    width: 100%;
    max-width: 60%;
    background-color: #f1f1f1;
    border-radius: 20px;
    padding: 5px 10px;
    box-sizing: border-box;
}

.inner-msg .mesg-send-inner i {
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}

.inner-msg .mesg-send-inner input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 16px;
    padding: 5px;
}

.inner-msg .send-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #007bff;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}


.inner-msg i.fa.fa-paper-plane {
    width: 55px;
    height: 54px;
}
.plus_images_add {
    display: flex;
    gap: 15px;
    justify-content: center;
}

.plus_images_add img {
    width: 68px;
    height: 68px;
    border: solid 4px #f15a295e;
}
.plus_images_add i.fa.fa-plus {
    background: none;
    color: #000;
    border: solid 2px #80808059;
    border-radius: 0;
    width: 68px;
    height: 68px;
    font-size: 15px;
}
.inner-msg span.number-text {
    margin-left: 36px;
    position: absolute;
    background-color: #fff;
    border-radius: 50px;
    width: 25px;
    height: 25px;
    top: 85px;
    font-size: 15px;
    font-weight: 700;
    color: #f15a29;
}


.image-group.whatsapp-show-img .image_fluid {
	width: 130px;
	margin: 2px;
	height: 120px;
}


@media  only screen and (max-width: 767px) {

div#modalBox img.inner-images {
    width: 100%;
    height: 350px;
}

.inner-msg .mesg-send-inner {
    max-width: 100%;
    padding: 5px 0px;
}

.inner-msg .input_inner_part {
    margin-left: 0px;
}

div#modalBox .modal-content  input#messageInput {
    margin-top: 25px;
}

div#modalBox .modal-content {
    height: 100%;
}
.msg-three-icons {
    display: flex;
    justify-content: center;
    margin-top: 13px;
    width: 100%;
}

.card-footer input#messageInput {
    border-radius: 50px;
    width: 100%;
    margin: 8px;
}


.chat.message-chat-right .card .card-footer {
    border-radius: 0px !important;
    padding: 20px 0;
}

.message-chat-new {
    margin-top: 25px !important;
}

.search-container input.search-input {
    padding: 6px 11px;
    padding-left: 24px;
}






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

.message-chat-new {
    width: 100%;
}
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
              padding: 11px 5px;
              margin-left: 0;
        }

        .message-chat-new {
            margin: 30px 0;
        }
    }

.drop-msg-receive .image_fluid {
	margin-bottom: 20px;
	width: 100%;
	height: 150px;
}
.drop-msg-receive {
	display: flex;
	flex-direction: column;
}
.drop-msg-send .image_fluid {
    margin-bottom: 20px;
    width: 100%;
    height: 150px;
    display: flex;
    align-items: center;
}

.loader-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7); /* Semi-transparent white */
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.3; /* Optional for additional transparency */
    z-index: 1;
}

/* Circular loader */
.loader-circle {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    animation: spin 1s linear infinite;
}

/* Wrapper for image and loader */
.image-wrapper {
    position: relative;
    display: inline-block;
}

/* Ensure the image is underneath the loader */
.image-wrapper img {
    display: block;
    width: 100%;
    height: auto;
    z-index: 0;
}

/* Keyframes for spinning loader */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.image-group.whatsapp-show-img {
	position: relative;
	display: flex;
	flex-wrap: wrap;
	width: 280px;
	height: 100%;
	background: #d3fed5;
	padding: 5px;
	padding-bottom: 35px;
}

.image-group.whatsapp-show-img .image {
    width: 48%;
    height: 48%;
    margin: 1%;
    object-fit: cover;
    border-radius: 4px;
    z-index: 1;
}

.image-group.whatsapp-show-img:after {
    left: -3px;
    background-color: #cbfed7;
    position: absolute;
    top: 19px;
    display: block;
    width: 13px;
    height: 13px;
    content: " ";
    transform: rotate(29deg) skew(-35deg);
}
.image-group.whatsapp-show-img .more-overlay {
    position: absolute;
    top: 108px;
    left: 140px;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    font-weight: bold;
    border-radius: 4px;
    z-index: 10;
    width: 132px;
    border-radius: 0;
}


.image-group {
  position: relative;
  display: inline-block; /* Adjust this based on your layout */
}

</style>




<div class="container-fluid h-100 message-chat-new">

    @php
    $onlineUser = auth('user')->user();
    $profileImage = $onlineUser->profile_image ? url('/public/admin/uploads/user/'.$onlineUser->profile_image) : url('/public/front_assets/images/reviw1.png');
    @endphp
    <input type="hidden" name="" id="user_image" value="{{ $profileImage }}">
    <div class="row h-100 message-chat-inner">
        <div class="col-md-3 chat message-chat-left">
            <div class="card mb-sm-3 mb-md-0 contacts_card">
                <div class="card-header">
                    <div class="input-group">
                        <input type="text" placeholder="Search..." name="" id="keyword-text" class="form-control search" />

                        <div class="input-group-prepend">
                            <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>

                <div id="results-container">
                <div class="card-body contacts_body" >
                    <ui class="contacts">
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
                    </ui>
                </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>

        <div class="col-md-9 chat message-chat-right">
            <form action="#" id="chat_form" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                        <div class="col-md-6 chat-box-left" id="user_header">
                            <h3 class="text-wight">Please Select User</h3>
                        </div>

                        <div class="col-md-6 chat-box-right">
                            <div class="chat-search">
                                <div class="search-container">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <input type="text" class="search-input" placeholder="Chat Search" />
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>

                    <div class="action_menu">
                        <ul>
                            <li><i class="fas fa-user-circle"></i> View profile</li>

                            <li><i class="fas fa-users"></i> Add to close friends</li>

                            <li><i class="fas fa-plus"></i> Add to group</li>

                            <li><i class="fas fa-ban"></i> Block</li>
                        </ul>
                    </div>
                </div>

                <div class="card-body msg_card_body" id="chat_div">

            <div class="image-group whatsapp-show-img">
              <img src="public/uploads/chat/cus677fbd497dd93.jpg" alt="Image 1" class="image">
              <img src="public/uploads/chat/cus677fbd497be46.jpg" alt="Image 2" class="image">
              <img src="public/uploads/chat/cus677fbeba3b155.jpg" alt="Image 3" class="image">
              <img src="public/uploads/chat/cus677fbeba3bac3.jpg" alt="Image 4" class="image">
              <div class="more-overlay">+5</div>
              <span class="msg_time_send">06:00 PM</span>
            </div>


                </div>

                <div class="card-footer">
                    <div class="input-group">
                        {{-- <input type="text" class="form-control type_msg" id="messageInput" placeholder="Type your message..." /> --}}
                        <input type="hidden" name="auth_id" id="auth_id" value="{{auth('user')->id()? auth('user')->id() :'0'}}">
                        <input type="text" id="my_msg" name="my_msg" class="form-control type_msg" placeholder="Type your message..."/>

                        <div class="msg-three-icons">
                            <i class="fas fa-smile"></i>

                            <i id="paperclip" class="fa fa-paperclip" aria-hidden="true"></i>

                            <!-- Popup with icons -->
                            <div id="popup" class="popup">
                                <div class="icon" id="docSharefile">
                                    <i class="fa fa-image"></i>
                                </div>

                                <!-- Hidden file input -->

                                <input type="file" name="file" id="my_file"  hidden multiple>

                                <script>
                                    // Get the div and file input elements
                                    const docSharefile = document.getElementById("docSharefile");
                                    const fileInput = document.getElementById("my_file");

                                    // Add event listener to trigger file input when clicking the div
                                    docSharefile.addEventListener("click", function () {
                                        fileInput.click(); // Open file picker
                                    });


                                    // Optional: Handle the selected files

                                </script>

                                <div class="icon" id="mediaSharefile">
                                    <i class="fa fa-video-camera"></i>
                                </div>

<div class="icon" id="imgSharefile">
    <i class="fa fa-file-text"></i>
</div>



<!-- Modal -->
<div id="modalBox" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="image-select-user">
            <!-- Most Recent Image Preview -->
            <img class="inner-images" id="previewImage" alt="Recent Preview">
        </div>

        <div class="message-container inner-msg">
            <div class="input_inner_part">
                <div class="mesg-send-inner">
                    <input type="text" id="messageInput" placeholder="Type a message...">
                    <i class="fa fa-smile-o" aria-hidden="true"></i>
                    <button class="send-btn">
                        <i class="fa fa-paper-plane"></i>
                        <span class="number-text"></span>
                    </button>
                </div>
            </div>

            <div class="plus_images_add">
                <!-- Placeholder for Thumbnail Previews -->
                <div id="thumbnailContainer" class="thumbnail-previews">
                    <!-- Dynamically added thumbnails will appear here -->
                </div>

                <!-- Add Image Button -->
                <label for="imageInput" style="cursor: pointer;">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </label>
                <input type="file" id="imageInput" multiple hidden>
            </div>
        </div>
    </div>
</div>

<!-- Styling -->
<style>
    .inner-images {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .thumbnail-previews {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .thumbnail-previews img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
    }
</style>


<script>
let firstImageData = null; // To store the first image's data
let selectedImages = [];
document.getElementById("my_file").addEventListener("change", function (event) {
    const files = Array.from(event.target.files);
    files.forEach(file => {
        selectedImages.push(file);
    });

    files.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            const preview = document.getElementById("previewImage");
            const thumbnailContainer = document.getElementById("thumbnailContainer");

            // Set main preview to the most recently selected image
            if (index === files.length - 1) {
                preview.src = e.target.result;
            }

            // Store the first image data if not already stored
            if (index === 0 && !firstImageData) {
                firstImageData = e.target.result;
            }

            // Add a thumbnail for each image
            const thumbnail = document.createElement("img");
            thumbnail.src = e.target.result;
            thumbnail.alt = "Thumbnail";
            thumbnail.addEventListener("click", () => {
                preview.src = e.target.result; // Change main preview on thumbnail click
            });

            // Append the thumbnail
            thumbnailContainer.appendChild(thumbnail);
        };

        reader.readAsDataURL(file);
    });

    const numberTextElement = document.querySelector(".number-text");
    numberTextElement.textContent = selectedImages.length;

    const modal = document.getElementById("modalBox");
    modal.style.display = "block";
});


const modal = document.getElementById("modalBox");

const span = document.querySelector(".close");
span.addEventListener("click", () => {
    modal.style.display = "none";
    const form = document.getElementById("chat_form"); // Replace 'myForm' with your form's actual ID
    form.reset();
    selectedImages = [];
    const thumbnailContainer = document.getElementById("thumbnailContainer");
    thumbnailContainer.innerHTML = "";



});

const btn = document.querySelector(".send-btn");
btn.addEventListener("click", () => {
    modal.style.display = "none";
    const thumbnailContainer = document.getElementById("thumbnailContainer");
    thumbnailContainer.innerHTML = "";
});


// Handle file input change
document.getElementById("imageInput").addEventListener("change", function (event) {
    const files = Array.from(event.target.files);
    files.forEach(file => {
        selectedImages.push(file);
    });

    files.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            const preview = document.getElementById("previewImage");
            const thumbnailContainer = document.getElementById("thumbnailContainer");

            // Set main preview to the most recently selected image
            if (index === files.length - 1) {
                preview.src = e.target.result;
            }

            // Store the first image data if not already stored
            if (index === 0 && !firstImageData) {
                firstImageData = e.target.result;
            }

            // Add a thumbnail for each image
            const thumbnail = document.createElement("img");
            thumbnail.src = e.target.result;
            thumbnail.alt = "Thumbnail";
            thumbnail.addEventListener("click", () => {
                preview.src = e.target.result; // Change main preview on thumbnail click
            });

            // Append the thumbnail
            thumbnailContainer.appendChild(thumbnail);
        };

        reader.readAsDataURL(file);
    });

    const numberTextElement = document.querySelector(".number-text");
    numberTextElement.textContent = selectedImages.length;
});



</script>


                                <input type="file" id="popup" accept="image/*" style="display: none;" />


                            </div>

                            <script>
                                // Get elements
                                const paperclip = document.getElementById("paperclip");
                                const popup = document.getElementById("popup");

                                // Toggle popup visibility on paperclip click
                                paperclip.addEventListener("click", () => {
                                    if (popup.style.display === "block") {
                                        popup.style.display = "none";
                                    } else {
                                        popup.style.display = "block";
                                    }
                                });

                                // Hide popup when clicking outside of it
                                document.addEventListener("click", (event) => {
                                    if (!popup.contains(event.target) && event.target !== paperclip) {
                                        popup.style.display = "none";
                                    }
                                });
                            </script>

                            <div class="input-group-append">
                                <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                            </div>

                            {{-- <button class="send-btn" id="sendMessageBtn">
                                <i class="fa fa-paper-plane"></i>
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
        <div class="center-message text-center">
            <p id="error_message" class="text-danger" style="display:none;">Please enter a message!</p>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

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
    let images = userData.msg_image;
    let imageElements = '';
        images.forEach(image => {
            imageElements += `<img src="${window.location.origin + '/public/uploads/chat/' + image}" alt="" class="image_fluid">`;
        });

  var messageHtml;

  if (userData.sender_id == currentUserId ) {
    // Append the message to the sender container
    messageHtml= `<div class="d-flex justify-content-end right-side-chat" id="${messageId}">
                <div class="msg_cotainer_send">
                ${userData.file_name
                    ? `<img src="${window.location.origin + '/public/uploads/chat/' + userData.file_name}" alt="" class="image_fluid">
                       <br><span class="msg_time_send">${userData.time}</span>`
                    : `<p>${userData.msg}<br><span class="timestamp">${userData.time}</span></p>`
                }
        </div>
         <div class="img_cont_msg">
            <img src="${userData.profile_image == null
                ? window.location.origin +'/public/front_assets/images/reviw1.png'
                : window.location.origin + '/public/admin/uploads/user/' + userData.profile_image}"
            alt="Sender Avatar" class="rounded-circle user_img">
        </div>
     </div>`;

     if ($(`#${messageId}`).length > 0) {
            $(`#${messageId}`).replaceWith(messageHtml);
        }

  } else {
    // Append the message to the receiver container
    messageHtml =`
    <div class="d-flex justify-content-start mb-4 side-left-chat">
        <div class="img_cont_msg">
        <img src="${userData.profile_image == null
            ? window.location.origin +'/public/front_assets/images/reviw1.png'
            : window.location.origin +'/public/admin/uploads/user/' + userData.profile_image}"
          alt="Sender Avatar" class="rounded-circle user_img">
      </div>
      <div class="msg_cotainer">
              ${images.length > 0
                ? `<div class="drop-msg-receive">${imageElements}${userData.msg}
                  </div><span class="msg_time_send">${userData.time}</span>`
                : `<div class="drop-msg-receive">${userData.msg}</div><span class="msg_time_send">${userData.time}</span>`
              }
        </div>
      </div>
      `;

      $('#chat_div').append(messageHtml);
  }


// Append the new element to the container
  $('#chat_div').animate({
        scrollTop: $('#chat_div')[0].scrollHeight
    }, 500);

  });
</script>

<script>
    $(".merchant-item").on("click", function () {
        $(".merchant-item").removeClass("active");
        var userId = $(this).data("id");
        const name = $(this).data('name');
        const image = $(this).data('image');
        const status = $(this).data('status');
        if(status == '1'){
            $('#user_header').html(`<div class="img_cont"><img src="${image}" class="rounded-circle user_img" />
                <span class="online_icon"></span></div><div class="user_info"><span>${name}</span></div>`);
        }else{
            $('#user_header').html(`<div class="img_cont"><img src="${image}" class="rounded-circle user_img" />
                <span class="online_icon offline"></span></div><div class="user_info"><span>${name}</span></div>`);
        }

        $(this).toggleClass("active");
    });
    $("#action_menu_btn").click(function () {
        $(".action_menu").toggle();
    });

    $(document).on('click', '.merchant-item', function() {
        const merchantId = $(this).data('id'); // Get the data-id attribute

        var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        // Perform AJAX request
        $.ajax({
            url: "{{url('/getUser')}}", // Replace with your backend route
            type: 'POST',
            datatype: "html",// or 'GET' depending on your requirement
            data: {
                id: merchantId,
                userTimeZone: userTimeZone,
                _token: '{{ csrf_token() }}' // Include CSRF token for security if using Laravel
            },
            success: function(response) {
                $('#chat_container').show();
                $('#chat_head').hide();
                $('#chat_div').html(response)
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

    $(document).on('keypress', '#my_msg', function(event) {
            if (event.which == 13) {
                var message = $('#my_msg').val();
                //var  message = $("#message").val();
                if ($.trim(message) == '') {
                    $('#error_message').show();
                    return false;
                } else {
                    event.preventDefault();
                    $('#chat_form').submit();
                }
            }
        });




    $('#chat_form').on('submit', function(event) {
      event.preventDefault();

      var my_msg = $('#my_msg').val();
      var user_profile = $('#user_image').val();
      var sender_id = $('#auth_id').val();
      var reciver_id = $('#reciver_id').val();
      var messageInput = $('#messageInput').val();



      if ($.trim(my_msg) == '' && selectedImages.length === 0) {
                    $('#error_message').show();
                    return false;
                } else {
            $('#error_message').hide();
            }

            var tempMsgId = 'temp-msg-' + Date.now();

        if (my_msg != null && my_msg.trim() !== '') {
            // Show the pre-message instantly
            $('#chat_div').append(`
                <div id="${tempMsgId}" class="d-flex justify-content-end mb-4 side-right-chat">
                    <div class="msg_cotainer_send">
                        <div class="drop-msg-send">
                            <span>${my_msg || 'Sending...'}</span>
                        </div>
                        <span class="msg_time_send">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true }).toUpperCase()}</span>
                    </div>
                    <div class="img_cont_msg">
                        <img src="${user_profile}" class="rounded-circle user_img" />
                    </div>
                </div>
            `);

            // Clear the message input
            $('#my_msg').val('');
        } else if (Array.isArray(selectedImages) && selectedImages.length > 0) {
            // Generate image elements from selectedImages
            let imageElements = '';
            selectedImages.forEach((image) => {
                imageElements += `<div class="position-relative">
                <img src="${URL.createObjectURL(image)}" alt="Selected Image" class="image_fluid">
                <div class="loader-overlay">
                    <div class="loader-circle"></div>
                </div>
                </div>`;
            });

            // Append the image block to the chat container
            $('#chat_div').append(`
                <div id="${tempMsgId}" class="d-flex justify-content-end mb-4 side-right-chat">
                    <div class="msg_cotainer_send">
                        <div class="drop-msg-send">
                            ${imageElements} ${messageInput}
                            <div class="loader"></div>
                        </div>
                        <span class="msg_time_send">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true }).toUpperCase()}</span>
                    </div>
                    <div class="img_cont_msg">
                        <img src="${user_profile}" class="rounded-circle user_img" />
                    </div>
                </div>
            `);
        }


    //  Select Images on loop show append==================================================================


// ========================================================================================================

        $('#chat_div').animate({
              scrollTop: $('#chat_div')[0].scrollHeight
        }, 500);


      var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

      var formData = new FormData();
      formData.append('my_msg', my_msg);
      formData.append('messageInput', messageInput);
      formData.append('sender_id', sender_id);
      formData.append('reciver_id', reciver_id);
      formData.append('userTimeZone', userTimeZone);
      formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
      selectedImages.forEach((image) => {
                formData.append('photos[]', image);

        });



      $.ajax({
            url: "{{url('/merchentMessageSubmit')}}",
            type: 'POST',
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                selectedImages = [];
              $('#preview-container').hide();
              $('#my_file').val('');
              $('#my_msg').val('');
              $('#' + tempMsgId).replaceWith(response.html);
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
    $('.send_btn').on('click', function() {
            $('#chat_form').submit(); // Trigger the form submission logic
    });
    </script>


<script>

function fetchFilteredResults() {
    const keywordTextValue = $('#keyword-text').val();

            $('#results-container').html("<div class='text-center' style='display:block'><img class='video-loader' src='{{ asset('public/admin/assets/images/lg.gif') }}' alt='Loading...'></div>");


            $.ajax({
                url: "{{ route('ajaxchatresults') }}", // Laravel route for loading results
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

@endsection
