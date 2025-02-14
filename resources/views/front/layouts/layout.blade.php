<!DOCTYPE html>

<html lang="en">

  <head>

    <title>Guruer</title>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="format-detection" content="telephone=no">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="author" content="">

    <meta name="keywords" content="">

    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

	<!-- <link href="{{ url('/public') }}/front_assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> @-->

    <link rel="stylesheet" href="{{ url('/public') }}/front_assets/css/bootstrap.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="{{ url('/public') }}/front_assets/css/vendor.css"> -->

    <link rel="stylesheet" type="text/css" href="{{ url('/public') }}/front_assets/style.css">
    <!--<link rel="stylesheet" type="text/css" href="{{ url('/public') }}/front_assets/matric.css">-->


    

   <!-- <link rel="stylesheet" type="text/css" href="{{ url('/public') }}/front_assets/detail.css"> -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">


    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

	<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">-->

	<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->

  </head>

  <body>



        @include('front.layouts.header')

        

        <!-- <script src="{{ url('/public') }}/front_assets/js/jquery-1.11.0.min.js"></script> -->

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
		<script src="{{ url('/public') }}/front_assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="{{ url('/public') }}/front_assets/js/plugins.js"></script>
        <script src="{{ url('/public') }}/front_assets/js/script.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


        @yield('content')

        @include('front.layouts.footer')

  </body>

</html>

