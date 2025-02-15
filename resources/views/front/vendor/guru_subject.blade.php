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
            <div class="col-md-12 grid-margin stretch-card customer-profile-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Subjects</h4>
                        <p class="card-description"></p>
                        <form class="profile-input-form customer-profile-form" action="{{url('guruSubject')}}" id="profile_form" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div id="add_more_subject">
                                @if($subcat)
                                @foreach($subcat as $val)
                                <div class="row customer-input-inner add_subjects">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Category</label>
                                            <select class="form-select cate_id" name="category_id[]" required>
                                                <option value="" disabled >Select Category</option>
                                                @foreach($category as $cat)
                                                <option value="{{$cat->id}}" {{$cat->id==$val->category_id?'selected':''}} >{{$cat->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    $subcateg = DB::table('sub_category')->select('id','sub_cat_name')->where('category_id',$val->category_id)->where('is_deleted',0)->where('is_active',1)->get();
                                    ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Subcategory</label>
                                            <select class="form-select subcat_id" name="sub_cat_id[]" required>
                                                @foreach($subcateg as $vacs)
                                                <option value="{{$vacs->id}}" {{$vacs->id==$val->subcategory_id?'selected':''}} >{{$vacs->sub_cat_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    $subj = DB::table('subjects')->select('id','subject_name')->where('subcategory_id',$val->subcategory_id)->where('is_deleted',0)->where('is_active',1)->get();
                                    $selectedSubjects = explode(',', $val->subject_id);
                                    ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Subject</label>
                                            <select class="form-select subject_id" name="subject_id[]" multiple="multiple" required>
                                            @foreach($subj as $vacss)
                                            <option value="{{$vacss->id}}" {{ in_array($vacss->id, $selectedSubjects) ? 'selected' : '' }}> {{$vacss->subject_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group" style="margin-top: 32px;">
                                            <span class="btn btn-outline-danger remove_sub"> - </span>    
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                
                            </div>
                            <div class="d-flex mt-3 sub-cen-btn">
                                    <span class="btn btn-outline-success me-2" id="add_subject">Add Subject</span>
                                </div>

                            <div class="d-flex mt-3 sub-cen-btn">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   $('#add_subject').click(function(){
    $('#add_more_subject').append(`<div class="row customer-input-inner add_subjects">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Category</label>
                                            <select class="form-select cate_id" name="category_id[]" required>
                                                <option value="" disabled >Select Category</option>
                                                @foreach($category as $cat)
                                                <option value="{{$cat->id}}"  >{{$cat->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Subcategory</label>
                                            <select class="form-select subcat_id" name="sub_cat_id[]" required>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Subject</label>
                                            <select class="form-select subject_id" name="subject_id[]" multiple="multiple" required>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group" style="margin-top: 32px;">
                                            <span class="btn btn-outline-danger remove_sub"> - </span>    
                                        </div>
                                    </div>
                                </div>`);
        initSelect();
   });

   $(document).on('click', '.remove_sub', function () {
        $(this).closest('.add_subjects').remove();
   });

    
   $(document).on('change', '.cate_id', function() {
        let categoryId = $(this).val();
        let subcategoryDropdown = $(this).closest('.row').find('.subcat_id');
        let subjectDropdown = $(this).closest('.row').find('.subject_id');

       // subcategoryDropdown.html('<option value="" disabled selected>Loading...</option>');
       // subjectDropdown.html('<option value="" disabled selected>Select Subject</option>');
       subcategoryDropdown.empty();
        subcategoryDropdown.val(null).trigger('change'); 
        subjectDropdown.val(null).trigger('change');
        
        $.ajax({
            url: "{{url('/getSubcategory')}}",
            type: "POST",
            datatype: "json",
            data: {
                categoryId: categoryId,
                '_token':'{{csrf_token()}}'
            },
            success: function(response) {
                //subcategoryDropdown.html('<option value="" disabled selected>Select Subcategory</option>');
                $.each(response, function(index, subcategory) {
                    subcategoryDropdown.append('<option value="' + subcategory.id + '">' + subcategory.sub_cat_name + '</option>');
                });
            },
            errror: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    $(document).on('change', '.subcat_id', function() {
    let subcategoryId = $(this).val();
    let subjectDropdown = $(this).closest('.row').find('.subject_id');

    // ✅ Clear the subject dropdown before appending new options
    subjectDropdown.empty().append('<option value="" disabled selected>Loading...</option>');
    
    $.ajax({
        url: "{{url('/getSubject')}}",
        type: "POST",
        dataType: "json",
        data: {
            subcategoryId: subcategoryId,
            '_token': '{{csrf_token()}}'
        },
        success: function(response) {
            
            subjectDropdown.empty();
           
            $.each(response, function(index, subject) {
                subjectDropdown.append('<option value="' + subject.id + '">' + subject.subject_name + '</option>');
            });

            subjectDropdown.trigger('change');
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});

    
</script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    function initSelect(){
        $('.subject_id').select2({
            placeholder: "Select options",
            allowClear: true
        });

        // $('.subcat_id').select2({
        //     placeholder: "Select options",
        //     allowClear: true
        // });
    }
$(document).ready(function(){
    initSelect();
})
        
    
</script>


@endsection