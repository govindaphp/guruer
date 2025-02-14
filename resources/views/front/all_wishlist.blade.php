@extends('front.layouts.layout') 
@section('content')

<style>
ul.list-unstyled.wishlist-pagination {
    margin-top: 30px;
    position: relative;
}
.wishlist-pagination img.img-fluid {
    object-fit: cover;
    width: 100%;
    padding: 0;
    border-radius: 0;
    margin-top: -2px;
    object-position: top;
}
.wishlist-pagination h5.card-title {
    text-align: center;
}

.wishlist-pagination button.btn.btn-primary.booknow_btn {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: auto;
    border: none;
    background: #f15a29;
    border: 1px solid #f15a29;
    width: 100%;
    justify-content: center;
    padding: 11px 0;
    border-radius: 50px;
    margin-top: 5px;
}
.wishlist-pagination button.btn.btn-primary.booknow_btn:hover {
    background-color: #000;
    border: 1px solid #000;
}
.cross-btn-new i.fa.fa-times {
    position: absolute;
    top: 11px;
    right: 18px;
    background-color: #f15a29;
    color: #fff;
    padding: 7px;
    border-radius: 50px;
    width: 30px;
    height: 30px;
    padding-left: 10px;
    cursor: pointer;
}
.wishlist-img {
    box-shadow: 0px 2px 15px 8px #d3d3d391;
    border: none;
}
.no-wishlist-add p {
    font-size: 25px;
    font-weight: 600;
    color: #f15a29;
    line-height: 12.1;
}

</style>


<!-- Bootstrap Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to remove the favorites status?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirmYes">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="confirmNo">No</button>
      </div>
    </div>
  </div>
</div>




<div class="banner-tailors">
    <div class="container browse-tailors">
        <div class="row browse-content">
            <h1 class="text-white">Wishlist</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="block-cgr">
        <div class="row result-container">
            <div class="pagination-container">
            <ul class="list-unstyled wishlist-pagination">
                @if($wishlist->isEmpty())
                    <div class="row">
                        <div class="col-12 text-center no-wishlist-add">
                            <p>No Wishlist</p> <!-- Message displayed when the wishlist is empty -->
                        </div>
                    </div>
                @else
                    @foreach($wishlist as $key => $value)
                        @if($key % 4 == 0)
                            <div class="row mb-4"> <!-- Start a new row every 4 items -->
                        @endif
                        
                        <div class="col-md-3" id="wishlistid{{$value->id}}">
                            <li class="outerli">
                                <div class="card mb-4 wishlist-img">
                                    <div class="image-extra">
                                        <div class="options_cust">
                                            <a href="#"><span class="{{ $value->online_status == 1 ? 'on_line' : 'off_line' }}"></span></a>
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
                                    <div class="cross-btn-new">

                                    @php
                                        $user = Auth::guard("user")->user();
                                        $session_user_id = $user->id ?? null;
                                        $profile_user_id = $value->id ?? null;
                                    @endphp
                                    <p class="userfollow" data-item="{{ $profile_user_id }}" data-num="{{ $session_user_id }}"><i class="fa fa-times" aria-hidden="true"></i></p>

                                    </div>
                                    <div class="card-body p-3">
                                        <h5 class="card-title">{{ @$value->first_name }}</h5>
                                        <div class="d-flex btns-group mb-2">
                                            <button type="button" class="btn btn-primary booknow_btn">
                                                <i class="fas fa-book"></i> Book Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>

                        @if(($key + 1) % 4 == 0 || $key == count($wishlist) - 1)
                            </div> <!-- Close the row after 4 items or the last item -->
                        @endif
                    @endforeach
                @endif



                <div class="row ajax-no-wishlist">
                    <div class="col-12 text-center no-wishlist-add">
                        <p>No Wishlist</p> <!-- Message displayed when the wishlist is empty -->
                    </div>
                </div>                


              
            </ul>

            </div>
        </div>
    </div>
</div>



<!--
<script>
$(document).ready(function () {
$(".userfollow").click(function () { 
   
    var user_id = $(this).attr("data-item"); //User Id
    var sender_user_id = $(this).attr("data-num"); //Sender User Id
    if (user_id) {
    

      var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
      var ajaxUrl = baseUrl + '/favorites_users_ajax'; // Construct the dynamic URL
      $.ajax({
        type: "POST",
        url: ajaxUrl,
        cache: false,
        data: {
            sender: sender_user_id,
            user: user_id,
            _token: "{{ csrf_token() }}" 
        },
        success: function (response) {  
           if(response == 1)
           $("#wishlistid" + user_id).remove();
          
           var badge = $(".update_heart_ajax");
           var currentCount = parseInt(badge.text()) || 0;
           badge.text(Math.max(currentCount - 1, 0)); // Decrease by 1, minimum 0
           refreshWishlist();
        },
      });
    
  } else {
    window.location.href = login_url;
  }


  


 // Function to refresh the wishlist
 function refreshWishlist() {
        var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
        var refreshUrl = baseUrl + '/get-updated-wishlist'; // New endpoint to fetch updated data

        $.ajax({
            type: "GET",
            url: refreshUrl,
            cache: false,
            success: function (response) {
            if (response.success) {
                // Update the wishlist dropdown
                var dropdownContent = '';
                if (response.wishlist.length > 0) {
                    response.wishlist.slice(0, 4).forEach(function (item) {
                        dropdownContent += `
                            <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="${item.profile_image}" alt="...">
                                    <div class="${item.online_status == 1 ? 'status-indicator bg-success' : ''}"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">${item.first_name}</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                        `;
                    });
                    dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
                } else {
                    dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
                }

                $(".chatnoti-open").html(`
                    <h6 class="dropdown-header">Wishlist</h6>
                    ${dropdownContent}
                `);
            }
        },
            error: function () {
                console.error("Failed to refresh the wishlist.");
            }
        });
    }




})
});
</script>
-->



<script>
$(document).ready(function () {
    $(".ajax-no-wishlist").hide();
    $(".userfollow").click(function () { 
        var user_id = $(this).attr("data-item"); // User Id
        var sender_user_id = $(this).attr("data-num"); // Sender User Id
        var button = $(this);

        // Check if user_id is present
        if (user_id) {
            // Show confirmation modal
            $("#confirmationModal")
                .data({
                    user_id: user_id,
                    sender_user_id: sender_user_id,
                    button: button
                })
                .modal('show');
        } else {
            // Redirect to login if user is not logged in
            window.location.href = login_url;
        }
    });

    // Handle "Yes" button click in the confirmation modal
    $("#confirmYes").click(function () {
        var modal = $("#confirmationModal");
        var user_id = modal.data("user_id");
        var sender_user_id = modal.data("sender_user_id");
        var button = modal.data("button");

        // Close the modal
        modal.modal('hide');

        // Execute AJAX call to remove the favorite
        var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
        var ajaxUrl = baseUrl + '/favorites_users_ajax'; // Construct the dynamic URL

        $.ajax({
            type: "POST",
            url: ajaxUrl,
            cache: false,
            data: {
                sender: sender_user_id,
                user: user_id,
                _token: "{{ csrf_token() }}" 
            },
            success: function (response) {  
                if (response == 1) {
                    $("#wishlistid" + user_id).remove(); // Remove the item from the DOM
                }

                // Update the badge counter
                var badge = $(".update_heart_ajax");
                var currentCount = parseInt(badge.text()) || 0;
                badge.text(Math.max(currentCount - 1, 0)); // Decrease by 1, minimum 0

                // Refresh the wishlist dropdown
                refreshWishlist();
            },
            error: function () {
                console.error("Failed to remove the favorite.");
            }
        });
    });

    // Handle "No" button click in the confirmation modal
    $("#confirmNo").click(function () {
        $("#confirmationModal").modal('hide');
    });

    // Function to refresh the wishlist

    /*
    function refreshWishlist() {
        var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
        var refreshUrl = baseUrl + '/get-updated-wishlist'; // New endpoint to fetch updated data

        $.ajax({
            type: "GET",
            url: refreshUrl,
            cache: false,
            success: function (response) {
                if (response.success) {
                    // Update the wishlist dropdown
                    var dropdownContent = '';
                    if (response.wishlist.length > 0) {
                        response.wishlist.slice(0, 4).forEach(function (item) {
                            dropdownContent += `
                                <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="${item.profile_image}" alt="...">
                                        <div class="${item.online_status == 1 ? 'status-indicator bg-success' : ''}"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">${item.first_name}</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                            `;
                        });
                        dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
                        $(".ajax-no-wishlist").hide();
                    } else {
                        dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
                        $(".ajax-no-wishlist").show();
                    }

                    $(".chatnoti-open").html(`
                        <h6 class="dropdown-header">Wishlist</h6>
                        ${dropdownContent}
                    `);
                }
            },
            error: function () {
                console.error("Failed to refresh the wishlist.");
            }
        });
    }

*/

function refreshWishlist() {
        var baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
        var refreshUrl = baseUrl + '/get-updated-wishlist';

        $.ajax({
            type: "GET",
            url: refreshUrl,
            cache: false,
            success: function (response) {
                if (response.success) {  
                    var dropdownContent = '';
                    if (response.wishlist.length > 0) {
                        response.wishlist.slice(0, 4).forEach(function (item) {
                            dropdownContent += `
                                <a class="dropdown-item d-flex align-items-center" href="/allwishlist">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="${item.profile_image}" alt="...">
                                        <div class="${item.online_status == 1 ? 'status-indicator bg-success' : ''}"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">${item.first_name}</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                            `;
                        });
                        dropdownContent += `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">Read More Wishlist</a>`;
                    } else {
                        dropdownContent = `<a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>`;
                    }

                    $(".chatnoti-open").html(`
                        <h6 class="dropdown-header">Wishlist</h6>
                        ${dropdownContent}
                    `);
                } else {
                    // Handle case where response.success is false
                    $(".ajax-no-wishlist").show();
                    $(".chatnoti-open").html(`
                        <h6 class="dropdown-header">Wishlist</h6>
                        <a class="dropdown-item text-center small text-gray-500" href="/allwishlist">No Wishlist available</a>
                    `);
                }
            },
            error: function () {
                console.error("Failed to refresh the wishlist.");
            }
        });
    }



});
</script>


@endsection
