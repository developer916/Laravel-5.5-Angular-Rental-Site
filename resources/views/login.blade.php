    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title') web.rentling @show</title>
    @section('meta_keywords')
        <meta name="keywords" content="rentling"/>
    @show @section('meta_author')
        <meta name="author" content="rentling"/>
    @show @section('meta_description')
        <meta name="description"
              content="app.rentling"/>
    @show
    @yield('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>
        .logo-default {
            margin: 4px 10px 0 !important;
        }
    </style>
    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="{{{ asset('assets/site/ico/favicon.ico') }}}">
</head>
<body class="page-md login">

<div class="logo">
    <a href="#">
        <img src="//s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHomeLogo-body-only.png" height="150" width="150" alt="">
    </a>
</div>
<div class="content">
    @include('flash::message')
    @yield('content')
    @yield('scripts')
</div>
<script>

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery(document).ready(function () {
        Login.init();
        $.backstretch([
                "https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/rentomato_city_1.png",
                "https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/rentomato_city_2.png",
                "https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/rentomato_city_3.png",
                "https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/rentomato_city_4.png",
                "https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/rentomato_city_5.png",
                "https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/rentomato_city_6.png",
                "https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/rentomato_city_7.png"
            ], {
                fade: 1000,
                duration: 1000
            }
        );
    });
</script>
</body>
</html>
