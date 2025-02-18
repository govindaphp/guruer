@extends('front.layouts.layout') @section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <div class="banner-tailors">
    <div class="container browse-tailors">
      <div class="row browse-content">
        <h1 class="text-white">Wallet Setting</h1>
      </div>
    </div>
  </div>

  <div class="container-fluid page-body-wrapper vendor-dasboard">
    @include('front.vendor.vendor_sidebar')
    <div class="row total-eran-list">
      <div class="col-md-3 total-earn-balance">
        <p>Total Earn Balance</p>
        <p class="payment-text"> ₹ 100</p>
      </div>
      <div class="col-md-3 total-earn-balance">
        <p>Wallet Balance</p>
        <p class="payment-text"> ₹ {{auth('user')->user()->wallet_amount}}</p>
      </div>
      
      <div class="col-md-3 cash-balance">
        <p>Base Price<span>₹ 10</span></p>          
        <p>Charge Per Minute<span>₹ 3</span></p>
        <p>Charge Per Text<span>₹ 15</span></p>
      </div>
    <div class="col-md-3 set-limit">
        <a href="#" class="edit-btn" id="editBtn" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
        <!--p>SET LIMITS</p-->
        <p>DOWNLOAD STATEMENT</p>
    </div>
    <!-- Bootstrap 5 Modal -->

      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Guruer Charge Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
              <div class="modal-body">
                <div class="mb-3">
                    <label for="chargePerText" class="form-label">Base Price:</label>
                    <input type="number" class="form-control"  name="base_price" placeholder="Enter amount" min=1>
                </div>
                <div class="mb-3">
                    <label for="chargePerMinute" class="form-label">Charge Per Minute:</label>
                    <input type="number" class="form-control"  name="minute_charge" placeholder="Enter amount" min=1>
                </div>
                <div class="mb-3">
                    <label for="chargePerText" class="form-label">Charge Per Text:</label>
                    <input type="number" class="form-control"  name="text_charge" placeholder="Enter amount" min=1>
                </div>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
              </div>
            </form>
          </div>
        </div>
      </div>

    <div class="video-chat-list">
      <div class="w3-bar w3-black">
        <button class="w3-bar-item w3-button" onclick="openCity('Video')">Video</button>
        <button class="w3-bar-item w3-button" onclick="openCity('Chat')">Chat</button>
      </div>

      <div id="Video" class="w3-container city">
        <div class="table-responsive">
          <table class="table table-striped table-condensed">
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email Address</th>
            </tr>
            <tr>
              <td>Hillary</td>
              <td>Nyakundi</td>
              <td>tables@mail.com</td>
            </tr>
            <tr>
              <td>Lary</td>
              <td>Mak</td>
              <td>developer@mail.com</td>
            </tr>
          </table>
        </div>
      </div>

      <div id="Chat" class="w3-container city" style="display:none">
        <div class="row">
          <div class="span5">
            <div class="table-responsive">
              <table class="table table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>Date registered</th>
                    <th>Role</th>
                    <th>Status</th>
                  </tr>
                </thead>   
                <tbody>
                  <tr>
                    <td>Donna R. Folse</td>
                    <td>2025/05/06</td>
                    <td>Editor</td>
                    <td><span class="label label-success">Active</span></td>                                       
                  </tr>
                  <tr>
                    <td>Emily F. Burns</td>
                    <td>2024/12/01</td>
                    <td>Staff</td>
                    <td><span class="label label-important">Banned</span></td>                                       
                  </tr>
                  <tr>
                    <td>Andrew A. Stout</td>
                    <td>2023/08/21</td>
                    <td>User</td>
                    <td><span class="label">Inactive</span></td>                             
                  </tr>
                  <tr>
                    <td>Mary M. Bryan</td>
                    <td>2024/04/11</td>
                    <td>Editor</td>
                    <td><span class="label label-warning">Pending</span></td>                                     
                  </tr>
                  <tr>
                    <td>Mary A. Lewis</td>
                    <td>2007/02/01</td>
                    <td>Staff</td>
                    <td><span class="label label-success">Active</span></td>                                       
                  </tr>                                   
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  

  <script>
  function openCity(cityName) {
    var i;
    var x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
    }
    document.getElementById(cityName).style.display = "block";  
  }
  </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection