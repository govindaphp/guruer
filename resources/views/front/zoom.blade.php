@extends('front.layouts.layout')



@section('content')

<div class="banner-tailors">
<div class="container browse-tailors">
  <div class="row browse-content">
    <h1 class="text-white">Meeting</h1>
  </div>
</div>
</div>


<div class="about-tailor-inner">
<div class="container">

    <?php //echo $start_url; ?>

    <iframe src="<?php echo $start_url; ?>" width="100%" height="600px" style="border:none;">
     
    </iframe>    

</div>

</div>




@endsection
