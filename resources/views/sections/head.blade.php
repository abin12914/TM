<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ env('APP_NAME', 'Trucking Manager') }} | @yield('title')</title>
<link rel="icon" href="/images/favicon.png">
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/css/dist/AdminLTE.min.css">
<!-- AdminLTE Skins. Make sure you apply the skin class to the body tag so the changes take effect. -->
<link rel="stylesheet" href="/css/dist/skins/skin-blue.min.css">

<!-- Google Font - (downloaded to file) -->
<link rel="stylesheet" href="/css/dist/fonts/googleapifont.css">
<!-- Select2 -->
<link rel="stylesheet" href="/bower_components/select2/dist/select2.min.css">
<!-- bootstrap-datepicker -->
<link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/bootstrap-datepicker.min.css">
{{-- sweet alert --}}
<link rel="stylesheet" href="/css/plugins/sweet_alert/sweetalert2.min.css">
{{-- custom css --}}
<link rel="stylesheet" href="/css/main.css">