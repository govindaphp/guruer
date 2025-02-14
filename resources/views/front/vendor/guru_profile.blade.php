@extends('front.layouts.layout') @section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="banner-tailors">
    <div class="container browse-tailors">
        <div class="row browse-content">
            <h1 class="text-white">Guruer-Profile</h1>
        </div>
    </div>
</div>

<div class="container-fluid page-body-wrapper vendor-dasboard">
    @include('front.vendor.vendor_sidebar')
    <div class="col-md-9">
        <div class="row profile-setting-form customer-profile">
            <div class="col-md-9 grid-margin stretch-card customer-profile-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Profile Update</h4>
                        <p class="card-description"></p>
                        <form class="profile-input-form customer-profile-form" action="{{url('profile_update')}}" id="profile_form" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row customer-input-inner">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="exampleInputName1" placeholder="First Name" value="{{ $customer->first_name }}" oninput="validateInput(this)"  />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName2">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="exampleInputName2" placeholder="Last Name" value="{{ $customer->last_name }}" oninput="validateInput(this)"  />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Email address</label>
                                        <input type="email" class="form-control" name="email_id" id="exampleInputEmail3" placeholder="Email" value="{{ $customer->email_id }}" readonly/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName2">Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile_number" id="exampleInputName2" placeholder="Mobile Number" value="{{ $customer->mobile_number }}" readonly/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName2">Price</label>
                                        <input type="text" class="form-control" name="price" id="exampleInputName2" placeholder="Enter Price" value="{{ $customer->price }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Gender</label>
                                        <select id="exampleSelectGender" class="form-select" name="gender" >
                                            <option value="" disabled {{ !$customer->gender ? 'selected' : '' }}>Select Gender</option>
                                            <option value="1" {{ $customer->gender == 1 ? 'selected' : '' }} >Male</option>
                                            <option value="2" {{ $customer->gender == 2 ? 'selected' : '' }} >Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Country</label>
                                        <select class="form-select" name="country_id" id="country">
                                            <option value="" disabled {{ !$customer->country_id ? 'selected' : '' }}>Select Country</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->country_id }}" {{ $customer->country_id == $country->country_id ? 'selected' : '' }}> {{ $country->country_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">State</label>
                                        <select class="form-select" name="state_id" id="state">
                                            <option value="" disabled>Select State</option>
                                            @foreach($state as $states_list)
                                                <option value="{{ $states_list->state_id }}" {{ $customer->state_id == $states_list->state_id  ? 'selected' : '' }}>
                                                    {{ $states_list->state_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">City</label>
                                        <select class="form-select" name="city_id" id="city">
                                        <option value="" disabled>Select City</option>
                                        @foreach($city as $city_list)
                                            <option value="{{ $city_list->city_id }}" {{ $customer->city_id == $city_list->city_id   ? 'selected' : '' }}>
                                                {{ $city_list->city_name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        @php
                                        $lang_id = [];
                                            if(!empty($UserLanguage)){
                                                foreach ($UserLanguage as $value){
                                                $lang_id[] = $value->language_id;
                                                }
                                            }
                                        @endphp
                                        <label for="exampleSelectGender">Language</label>
                                        <select  name="language[]" class="form-select exampleInputColor" multiple="multiple" required>
                                        @if(!empty($language))
                                        @foreach ($language as $value)
                                        <option value="{{$value->language_id}}" @if(in_array($value->language_id, $lang_id)) selected @endif>{{$value->language_name}}</option>
                                        @endforeach
                                        @else
                                        <option value="1">Hindi</option>
                                        <option value="2">English</option>
                                        @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        @php
                                        $subject_id =[];
                                            if(!empty($userSubject)){
                                                foreach ($userSubject as $key => $value) {
                                                    $subject_id[] = $value->subject_id;
                                                }
                                            }
                                        @endphp
                                        <label for="exampleSelectGender">Subjects</label>
                                        <select  name="subjects[]" class="form-select exampleInputColor" multiple="multiple" required>
                                        @if(!empty($subjects))
                                        @foreach ($subjects as $value)
                                        <option value={{ $value->id }} @if(in_array($value->id, $subject_id)) selected @endif>{{ $value->subject_name }}</option>
                                        @endforeach
                                        @else
                                        @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Postal Code</label>
                                        <input type="text" class="form-control" name="zipcode" id="exampleInputName2" placeholder="Postal Code" value="{{ $customer->zipcode }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Address</label>
                                        <textarea class="form-control" name="address" id="exampleTextarea1" rows="4" required>{{ $customer->address }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="videoType">Video Type</label>
                                        <select class="form-select" name="video_type" id="videoType" required>
                                            <option value="" disabled {{ empty($customer->video_type) ? 'selected' : '' }}>Select Video Type</option>
                                            <option selected value="1" {{ $customer->video_type == 1 ? 'selected' : '' }}>Embed</option>
                                            <option value="2" {{ $customer->video_type == 2 ? 'selected' : '' }}>MP4</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="embedInput" style="display: none;">
                                    <div class="form-group">
                                        <label for="embedUrl">Embed URL</label>
                                        <input type="url" class="form-control" name="embed_url" id="embedUrl" placeholder="Enter video embed URL">
                                        <span>{{ $customer->video_data }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6" id="fileInput" style="display: none;">
                                    <div class="form-group">
                                        <label for="videoFile">Browse Video File</label>
                                        <input type="file" class="form-control" name="video_file" id="videoFile" accept="video/mp4">
                                        <span>{{ $customer->video_data }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mt-3 sub-cen-btn">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-3 profile-right customer-profile-right">
                <div class="card">
                    <div class="card-body">
                        <h4>Profile Image</h4>
                        <label for="profile-image" class="upload-label" style="cursor: pointer;">
                            <img id="preview" src="{{ $customer->profile_image==''? asset('public/front_assets/images/default-img.jpg') : url('/public').'/admin/uploads/user/'.$customer->profile_image }} " alt="Profile Image" style="width: 100%; max-width: 200px; border: 1px dashed #ccc; padding: 10px;" />
                            <span>Please Upload Image</span>
                        </label>
                        <input type="file" id="profile-image" style="display: none;" accept="image/*" name="profile_image"/>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('profile-image');
    const previewImage = document.getElementById('preview');

    fileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result; // Update the image preview
            };
            reader.readAsDataURL(file);
        }
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    window.addEventListener("load", function () {
        $("#course_form").validate({
            rules: {
                first_name: { required: true },
                last_name: { required: true },
                email_id: {
                    required: true,
                    email: true,
                },
                mobile_number: { required: true },
                user_address: { required: true },
            },

            messages: {
                first_name: { required: "First name is required" },
                last_name: { required: "Last name is required" },
                email_id: { required: "Email is required", email: "Enter a valid email" },
                mobile_number: { required: "Mobile number is required" },
                user_address: { required: "Address is required" },
            },

            errorElement: "span",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.exampleInputColor').select2({
            placeholder: "Select options",
            allowClear: true
        });

        $('#country').change(function () {
            var cid = this.value;   //let cid = $(this).val(); we cal also write this.
            $.ajax({
                url: "{{url('/getstate')}}",
                type: "POST",
                datatype: "json",
                data: {
                    country_id: cid,
                    '_token':'{{csrf_token()}}'
                },
                success: function(result) {
                    $('#state').html('<option value="">Select State</option>');
                    $.each(result.state, function(key, value) {
                    $('#state').append('<option value="' +value.state_id+ '">' +value.state_name+ '</option>');
                    });
                },
                errror: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#state').change(function () {
            var sid = this.value;
            $.ajax({
                url: "{{url('/getcity')}}",
                type: "POST",
                datatype: "json",
                data: {
                    state_id: sid,
                    '_token':'{{csrf_token()}}'
                },

                success: function(result) {
                    console.log(result);
                    $('#city').html('<option value="">Select City</option>');
                    $.each(result.city, function(key, value) {
                    $('#city').append('<option value="' +value.city_id+ '">' +value.city_name+ '</option>')
                    });
                },
                errror: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var defaultValue = $('#videoType').val();
        if (!defaultValue) {
            defaultValue = 1; // Set default value        
        }
        initializeVideoTypeSelection(defaultValue); // Default value is 'embed'
    });


    function initializeVideoTypeSelection(defaultValue ) {
        const videoTypeSelect = document.getElementById('videoType');
        const embedInput = document.getElementById('embedInput');
        const fileInput = document.getElementById('fileInput');

        function toggleInputFields(selectedValue) {
            if (selectedValue === '1') {
                embedInput.style.display = 'block';
                fileInput.style.display = 'none';
            } else if (selectedValue === '2') {
                fileInput.style.display = 'block';
                embedInput.style.display = 'none';
            } else {
                embedInput.style.display = 'none';
                fileInput.style.display = 'none';
            }
        }

        // Set default value and toggle inputs
        videoTypeSelect.value = defaultValue;
        toggleInputFields(defaultValue);

        // Add event listener for dropdown change
        videoTypeSelect.addEventListener('change', function () {
            toggleInputFields(this.value);
        });
    }
</script>

<script>
function validateInput(input) {
    // Remove non-alphabetic characters (including numbers)
    input.value = input.value.replace(/[^a-zA-Z ]/g, '');

    // Optionally, you can show an error message if the length exceeds 15 characters.
    if (input.value.length > 15) {
        input.value = input.value.slice(0, 15); // Ensure the value is cut off at 15 characters
    }
}
</script>

@endsection