@extends('admin.layouts.layout')

@section('title','Guruer List')
@section('admin-content')





<style>
  div#datatable-buttons_length {
    width: 50% !important;
  }

  div#datatable-buttons_filter {
    margin-top: -48px;
    margin-bottom: 14px;
  }

  .dt-buttons.btn-group a.btn {
    border: solid 2px #80808036;
    display: flex;
    margin-bottom: 12px;
    border-radius: 5px;
  }

  a.btn.btn-default.buttons-copy.buttons-html5.btn-sm {
    border-radius: 5px;
  }

  a.btn.btn-default.buttons-csv.buttons-html5.btn-sm {
    border-radius: 5px;
  }

  a.btn.btn-default.buttons-excel.buttons-html5.btn-sm {
    border-radius: 5px;
  }

  a.btn.btn-default.buttons-pdf.buttons-html5.btn-sm {
    border-radius: 5px;
  }

  a.btn.btn-default.buttons-print.btn-sm {
    border-radius: 5px;
  }

  .dt-buttons.btn-group {
    gap: 11px;
  }

  .toggle-group .btn {
    font-size: 13px;
  }

  select#heard12 {
    font-size: 14px;
  }

  .table-responsive .table td,
  .table th {
    padding-bottom: 0px;
  }

  .col-md-3.go-back-btn.mt-1 {
    margin-top: 27px !important;
  }
</style>

<!-- Bootstrap Toggle CSS -->


<!-- Bootstrap Toggle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


<div class="right_col" role="main">
  <div class="">
  <div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">



    <div class="clearfix"></div>

    <!-- <div class="row" id="resultsContainer" > -->
    <div class="row" id="resultsContainer" >
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Tailor List</h2>
            <a href="{{route('admin.tailor_form')}}" class="btn btn-primary">Add New</a>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                  <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile No.</th>
                        <th>Guruer Type</th>
                        <th>Account Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php $i = 1; ?>
                      @foreach ($guruer_list as $list)
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$list->first_name}}</td>
                        <td>{{$list->email_id}}</td>
                        <td>{{$list->mobile_number}}</td>
                        <td>
                          @if($list->user_type == 1)
                          Expert
                          @else
                          Guruer
                          @endif
                        </td>
                        <td class="approve-btn">
                          <input data-id="{{$list->id}}" class="toggle-class" type="checkbox"
                            data-onstyle="success" data-offstyle="danger"
                            data-toggle="toggle" data-on="Approved" data-off="Suspended"
                            {{ $list->	user_status ? 'checked' : '' }}>
                        </td>
                        <td>
                          <a href="{{ url('admin/guruer-view',$list->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                          <a href="{{ url('admin/guruer-edit',$list->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                          <a title="Delete User" class="btn btn-sm btn-danger" href="{{ route('admin.delete_vendor_list',$list->id )}}" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-trash"></i>
                        </td>
                      </tr>
                      <?php $i++; ?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.toggle-class').bootstrapToggle();
  });
</script>
<script>
  $('.toggle-class').on("change", function() {
    var status = $(this).prop('checked') == true ? 1 : 0;
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?php echo url('/admin/vendor-status'); ?>",
      data: {
        _token: '{{ csrf_token() }}',
        'status': status,
        'id': id
      },
      success: function(data) {
        if (data.success) {
          toastr.success('Status changed successfully');

        } else {
          toastr.error('Failed to change status');
        }
      },
    });
  });
</script>

<script>
  $(document).ready(function() {
    @if(Session::has('message'))
    toastr.success("{{ Session::get('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif
  });
</script>

<script>
  $(document).ready(function() {
  // Function to apply the filter
  $('#applyFilter').click(function() {
    // Get the selected values from the filter fields
    const customerType = $('#customerType').val();
    const accountStatus = $('#accountStatus').val();

    // alert(customerType);
    // Validate if fields are selected
    if (!customerType && !accountStatus) {
      alert("Please select any of the Field");
      return;
    }

    // Construct the filter data
    const filterData = {
      customer_type: customerType,
      account_status: accountStatus,
      _token: "{{ csrf_token() }}" // Include CSRF token for Laravel
    };

    // AJAX request to send the filter data
    $.ajax({
      url: '{{ url('/admin/vendor-filter')}}', // Replace with your server endpoint
      type: 'POST',
      data: filterData,
      success: function(response) {
        // Handle the filtered results
        $('#resultsContainer').html(response);
        // For example, you might update a table with the results here
        // $('#resultsTable').html(response);
      },
      error: function(xhr, status, error) {
        console.error("Error:", error);
      }
    });
  });

  // Function to reset the filter
  $('#resetFilter').click(function() {
    // Clear the filter fields
    $('#customerType').val("");
    $('#accountStatus').val("");
  });
});

</script>

@endsection