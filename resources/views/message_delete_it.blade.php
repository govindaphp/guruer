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


@media only screen and (max-width: 767px) {
        
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
</style>



<div class="container-fluid h-100 message-chat-new">
    <div class="row h-100 message-chat-inner">
        <div class="col-md-3 chat message-chat-left">
            <div class="card mb-sm-3 mb-md-0 contacts_card">
                <div class="card-header">
                    <div class="input-group">
                        <input type="text" placeholder="Search..." name="" class="form-control search" />

                        <div class="input-group-prepend">
                            <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="card-body contacts_body">
                    <ui class="contacts">
                        <li class="active">
                            <div class="d-flex bd-highlight">
                                <div class="left-inner-value">
                                    <div class="img_cont">
                                        <img src="/public/admin/uploads/user/cus1733491065.jpg" class="rounded-circle user_img" />
                                        <span class="online_icon"></span>
                                    </div>

                                    <div class="user_info">
                                        <span>Sushil</span>
                                        <p><i class="fa fa-camera" aria-hidden="true"></i> Photo</p>
                                    </div>
                                </div>
                                <div class="time_zone">
                                    <span class="time">11:09 AM</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="d-flex bd-highlight">
                                <div class="left-inner-value">
                                    <div class="img_cont">
                                        <img src="/public/front_assets/images/named.png" class="rounded-circle user_img" />
                                        <span class="online_icon"></span>
                                    </div>

                                    <div class="user_info">
                                        <span>Sami dark</span>
                                        <p><i class="fa fa-camera" aria-hidden="true"></i> Photo</p>
                                    </div>
                                </div>

                                <div class="time_zone">
                                    <span class="time">08:38 PM</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="d-flex bd-highlight">
                                <div class="left-inner-value">
                                    <div class="img_cont">
                                        <img src="/public/front_assets/images/instagram-profile.png" class="rounded-circle user_img" />
                                        <span class="online_icon"></span>
                                    </div>

                                    <div class="user_info">
                                        <span>Nargis</span>
                                        <p><i class="fa fa-file-text"></i>File</p>
                                    </div>
                                </div>

                                <div class="time_zone">
                                    <span class="time">09:16 AM</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="d-flex bd-highlight">
                                <div class="left-inner-value">
                                    <div class="img_cont">
                                        <img src="/public/front_assets/images/hand-drawing-cartoon.png" class="rounded-circle user_img" />
                                        <span class="online_icon"></span>
                                    </div>

                                    <div class="user_info">
                                        <span>Taniya</span>
                                        <p><i class="fa fa-image"></i>Photos</p>
                                    </div>
                                </div>

                                <div class="time_zone">
                                    <span class="time">01:00 AM</span>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="d-flex bd-highlight">
                                <div class="left-inner-value">
                                    <div class="img_cont">
                                        <img src="/public/front_assets/images/named.png" class="rounded-circle user_img" />
                                        <span class="online_icon"></span>
                                    </div>

                                    <div class="user_info">
                                        <span>Preeti</span>
                                        <p><i class="fas fa-microphone-alt"></i>Audio</p>
                                    </div>
                                </div>

                                <div class="time_zone">
                                    <span class="time">12:00 AM</span>
                                </div>
                            </div>
                        </li>
                    </ui>
                </div>

                <div class="card-footer"></div>
            </div>
        </div>

        <div class="col-md-9 chat message-chat-right">
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                        <div class="col-md-6 chat-box-left">
                            <div class="img_cont">
                                <img src="/public/front_assets/images/named.png" class="rounded-circle user_img" />

                                <span class="online_icon"></span>
                            </div>
                            <div class="user_info">
                                <span>Muskan</span>
                                <p>58 Messages</p>
                            </div>
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

                <div class="card-body msg_card_body">
           <div class="d-flex justify-content-end mb-4 side-right-chat">
        <div class="msg_cotainer_send">
            <div class="drop-msg-send">
                <div class="dropdown">
                    <button class="new-add-drop" onclick="toggleDropdown('dropdown-send')"><i class="fa fa-angle-down"></i></button>
                    <ul class="dropdown-menu" id="dropdown-send" style="display: none;">
                        <li onclick="editMessage()">Edit</li>
                        <li onclick="copyMessage()">Copy</li>
                        <li onclick="replyMessage()">Reply</li>
                        <li onclick="removeMessage()">Remove</li>
                        <li onclick="forwardMessage()">Forward</li>
                    </ul>
                </div>
                <span>Hi Simi, I am good tnx, how about you?</span>
            </div>
            <span class="msg_time_send">8:55 AM, Today</span>
        </div>
        <div class="img_cont_msg">
            <img src="/public/admin/uploads/user/cus1733491065.jpg" class="rounded-circle user_img" />
        </div>
    </div>

    <!-- Left Side Chat (Received Message) -->
    <div class="d-flex justify-content-start mb-4 side-left-chat">
        <div class="img_cont_msg">
            <img src="public/admin/uploads/user/cus1733491065.jpg" />
        </div>
        <div class="msg_cotainer">
            <div class="drop-msg-receive">
                <div class="dropdown">
                    <button class="new-add-drop" onclick="toggleDropdown('dropdown-receive')"><i class="fa fa-angle-down"></i></button>
                    <ul class="dropdown-menu" id="dropdown-receive" style="display: none;">
                        <li onclick="editMessage()">Edit</li>
                        <li onclick="copyMessage()">Copy</li>
                        <li onclick="replyMessage()">Reply</li>
                        <li onclick="removeMessage()">Remove</li>
                        <li onclick="forwardMessage()">Forward</li>
                    </ul>
                </div>
                <span>I’m good too, thanks for asking!</span>
            </div>
            <span class="msg_time_receive">8:56 AM, Today</span>
        </div>
    </div>





                    <div class="d-flex justify-content-end mb-4 side-right-chat">
                        <div class="msg_cotainer_send">
                            <div class="drop-msg-send">
                                <div class="dropdown">
                                <button class="new-add-drop" onclick="toggleDropdown()"><i class="fa fa-angle-down"></i></button>
                                <ul class="dropdown-menu" id="dropdown-menu" style="display: none;">
                                    <li onclick="editMessage()">Edit</li>
                                    <li onclick="copyMessage()">Copy</li>
                                    <li onclick="replyMessage()">Reply</li>
                                    <li onclick="removeMessage()">Remove</li>
                                    <li onclick="forwardMessage()">Forward</li>
                                </ul>
                            </div>
                                <span> You are welcome</span>
                            </div>
                            <span class="msg_time_send">9:05 AM, Today</span>
                        </div>

                        <div class="img_cont_msg">
                            <img src="/public/front_assets/images/hand-drawing-cartoon.png" class="rounded-circle user_img" />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mb-4 side-right-chat">
                        <div class="msg_cotainer_send">
                            <div class="drop-msg-send">
                                     <div class="dropdown">
                                    <button class="new-add-drop" onclick="toggleDropdown()"><i class="fa fa-angle-down"></i></button>
                                    <ul class="dropdown-menu" id="dropdown-menu" style="display: none;">
                                        <li onclick="editMessage()">Edit</li>
                                        <li onclick="copyMessage()">Copy</li>
                                        <li onclick="replyMessage()">Reply</li>
                                        <li onclick="removeMessage()">Remove</li>
                                        <li onclick="forwardMessage()">Forward</li>
                                    </ul>
                                </div>
                                <div id="message-box" style="display: none;">
    <input type="text" id="message-input" placeholder="Type your message..." />
    <button onclick="saveMessage()">Save</button>
</div>
                                <span>Ok</span>
                            </div>
                            <span class="msg_time_send">9:10 AM, Today</span>
                        </div>

                        <div class="img_cont_msg">
                            <img src="/public/front_assets/images/hand-drawing-cartoon.png" class="rounded-circle user_img" />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control type_msg" id="messageInput" placeholder="Type your message..." />

                        <div class="msg-three-icons">
                            <i class="fa fa-smile-o" aria-hidden="true"></i>

                            <i id="paperclip" class="fa fa-paperclip" aria-hidden="true"></i>

                            <!-- Popup with icons -->
                            <div id="popup" class="popup">
                                <div class="icon" id="docSharefile">
                                    <i class="fa fa-file-text"></i>
                                </div>

                                <!-- Hidden file input -->
                                <input type="file" id="fileInput" style="display: none;" />

                                <script>
                                    // Get the div and file input elements
                                    const docSharefile = document.getElementById("docSharefile");
                                    const fileInput = document.getElementById("fileInput");

                                    // Add event listener to trigger file input when clicking the div
                                    docSharefile.addEventListener("click", function () {
                                        fileInput.click(); // Open file picker
                                    });

                                    // Optional: Handle the selected files
                                    fileInput.addEventListener("change", function () {
                                        const files = fileInput.files;
                                        if (files.length > 0) {
                                            console.log("Selected files:", files);
                                        }
                                    });
                                </script>

                                <div class="icon" id="mediaSharefile">
                                    <i class="fa fa-video-camera"></i>
                                </div>

<div class="icon" id="imgSharefile">
    <i class="fa fa-image"></i>
</div>

<!-- Modal Box -->
<div id="modalBox" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
    <div class="image-select-user">
    <img class="inner-images" src="public/admin/uploads/user/men-three.jpg">

    <div class="message-container inner-msg">
   <div class="input_inner_part">
    <div class="mesg-send-inner">
        <input type="text" id="messageInput" placeholder="Type a message..." ><i class="fa fa-smile-o" aria-hidden="true"></i>


        <button class="send-btn">
            <i class="fa fa-paper-plane"></i>
            <span class="number-text">1</span>
        </button>
    </div>


</div>

<div class="plus_images_add">
    <img src="public/admin/uploads/user/men-three.jpg" class="plus-images-one">
   <i class="fa fa-plus" aria-hidden="true"></i>

    
</div>
    </div>
</div>

    </div>
</div>


<script>
    
// Get the modal
const modal = document.getElementById("modalBox");

// Get the button that opens the modal
const btn = document.getElementById("imgSharefile");

// Get the <span> element that closes the modal
const span = document.querySelector(".close");

// When the user clicks on the button, open the modal
btn.addEventListener("click", () => {
    modal.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
span.addEventListener("click", () => {
    modal.style.display = "none";
});

// When the user clicks anywhere outside of the modal, close it
window.addEventListener("click", (event) => {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});


</script>

                                <input type="file" id="imageInput" accept="image/*" style="display: none;" />

                               
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

                            <button class="send-btn" id="sendMessageBtn">
                                <i class="fa fa-paper-plane"></i>
                            </button>

                            <script>
                                document.getElementById("sendMessageBtn").addEventListener("click", function () {
                                    const messageInput = document.getElementById("messageInput");
                                    const message = messageInput.value.trim();

                                    if (message) {
                                        // Send the message to your server or handle it here
                                        console.log("Message Sent: " + message);

                                        // Optionally, clear the input field after sending
                                        messageInput.value = "";
                                    } else {
                                        alert("Please type a message before sending.");
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdown-menu');
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            dropdownMenu.style.display = 'block';
        } else {
            dropdownMenu.style.display = 'none';
        }
    }

    function editMessage() {
        // Show the message input box when "Edit" is clicked
        document.getElementById('message-box').style.display = 'block';
    }

    function saveMessage() {
        var message = document.getElementById('message-input').value;
        if (message) {
            alert('Message saved: ' + message);  // You can replace this with a more complex action.
        }
        document.getElementById('message-box').style.display = 'none';  // Hide the input box after saving
    }

    // Placeholder functions for other actions
    function copyMessage() {
        alert('Message copied');
    }

    function replyMessage() {
        alert('Replying to message');
    }

    function removeMessage() {
        alert('Message removed');
    }

    function forwardMessage() {
        alert('Message forwarded');
    }
</script>

<script>
    $(document).ready(function () {
        $("#action_menu_btn").click(function () {
            $(".action_menu").toggle();
        });
    });
</script>

@endsection
