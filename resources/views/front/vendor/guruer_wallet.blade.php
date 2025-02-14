@extends('front.layouts.layout') @section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="banner-tailors">

<div class="container browse-tailors">

  <div class="row browse-content">

    <h1 class="text-white">Guruer Wallet</h1>

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

<div class="col-md-3 cash-balance">
	<p>Charge Per Text<span>₹ 80</span></p>
	<p>Charge Per Minute<span>₹ 90</span></p>

</div>

<div class="col-md-6 set-limit">
    <a href="#" class="edit-btn" id="editBtn">Edit</a>
	<p>SET LIMITS</p>
	<p>DOWNLOAD STATEMENT</p>
</div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Guruer Charge Details</h2>
			<div class="charge-per-offer">          
			<label for="chargePerText">Charge Per Text:</label>
			<input type="number" id="chargePerText" name="chargePerText" placeholder="Enter amount">
			</div>

			<div class="charge-per-offer">
			<label for="chargePerText">Charge Per Minute:</label>
			<input type="number" id="chargePerText" name="chargePerText" placeholder="Enter amount">
			</div>
			<a href="#" class="submit-btn">SUBMIT</a>
        </div>
    </div>

     <script>
        // Get modal element and button
        const modal = document.getElementById("editModal");
        const editBtn = document.getElementById("editBtn");
        const closeBtn = document.querySelector(".close-btn");

        // Open modal when Edit button is clicked
        editBtn.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior
            modal.style.display = "block";
        });

        // Close modal when close button is clicked
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });

        // Close modal if user clicks outside the modal content
        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    </script>



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


</div>

</div>




                </div>


            </div>




        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>







@endsection

