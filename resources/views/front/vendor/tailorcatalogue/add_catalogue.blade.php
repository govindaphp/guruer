@extends('front.layouts.layout') @section('content')

<div class="banner-tailors">
<div class="container browse-tailors">
  <div class="row browse-content">
    <h1 class="text-white">Catalogue Create-Update</h1>
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
                                <h4 class="card-title">Catalogue</h4>
                                <p class="card-description">Basic Details</p>
                                <form class="profile-input-form customer-profile-form" action="{{ url('/addCatalogue') }}" id="profile_form" enctype="multipart/form-data" method="POST">
                                @csrf
                                    <div class="row customer-input-inner">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="hidden" name="catalogue_id" value="{{@$catalogue->id}}">
                                                <label for="exampleInputName1">Catalogue Name</label>
                                                <input type="text" class="form-control" name="catalogue_name" id="exampleInputName1" placeholder="Catalogue Name" value="{{@$catalogue->catalogue_name}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName2">Start Price</label>
                                                <input type="text" class="form-control" name="start_price" id="exampleInputName2" placeholder="Start Price" value="{{@$catalogue->start_price}}" require/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleSelectGender">Category</label>
                                                    <select class="form-select" name="category_id" id="state" required>
                                                    <option value="" disabled>Choose Category</option>
                                                    @foreach($Category as $value)
                                                    <option value="{{ $value->category_id }}" {{@$catalogue->category_id == $value->category_id ? 'selected' : '' }}>{{$value->category_name}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleSelectGender">Gender</label>
                                                <select class="form-select" name="gender_type" id="city" required>
                                                <option value="">Select Gender</option>
                                                <option value="1" {{@$catalogue->gender_type == '1' ? 'selected' : '' }}>Male</option>
                                                <option value="2" {{@$catalogue->gender_type == '2' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-3 sub-cen-btn">
                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                        <button class="btn btn-light">Cancel</button>
                                    </div>
                                
                            </div>
                        </div>
                    </div>

                </form>


                </div>
            </div>
        </div>


@endsection
