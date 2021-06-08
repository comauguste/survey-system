<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../">
    <meta charset="utf-8"/>
    <title>Next Generation | Survey System</title>
    <meta name="description"
          content="Craft admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets."/>
    <meta name="keywords"
          content="Craft, bootstrap, bootstrap 5, admin themes, free admin themes, bootstrap admin, bootstrap dashboard"/>
    <link rel="canonical" href="Https://preview.keenthemes.com/craft"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{asset('media/logos/favicon.ico')}}"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
    @yield('css-compose')
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="bg-white header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">

@yield('content')
<!--end::Main-->
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('js/custom/authentication/sign-in/general.js')}}"></script>
<!--end::Page Custom Javascript-->
@yield('javascript')
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
