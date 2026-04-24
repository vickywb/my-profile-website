<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="description" content="Studio Gallery">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   
      <!-- Title  -->
      <title>@yield('title')</title>

      <!-- Meta Ads -->
      <meta name="description" content="pohotgrapher, photo studio, studio" />

      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="{{ asset('backend/img/favicon/favicon.ico') }}" />
   
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
      />
   
      <!-- Icons. Uncomment required icon fonts -->
      <link rel="stylesheet" href="{{ asset('backend/fonts/boxicons.css') }}" />
   
      <!-- Core CSS -->
      <link rel="stylesheet" href="{{ asset('backend/css/core.css') }}" class="template-customizer-core-css" />
      <link rel="stylesheet" href="{{ asset('backend/css/theme-default.css') }}" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="{{ asset('backend/css/demo.css') }}" />
   
      <!-- Vendors CSS -->
      <link rel="stylesheet" href="{{ asset('backend/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
   
      <link rel="stylesheet" href="{{ asset('backend/libs/apex-charts/apex-charts.css') }}" />

      <!-- Page CSS -->
      <script src="{{ asset('backend/js/helpers.js') }}"></script>

      <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
      <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
      <script src="{{ asset('backend/js/config.js') }}"></script>

      @stack('styles')
   </head>
   <body>

    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
          @include('partials.backend.sidebar')
        <!-- / Menu -->
  
        <!-- Layout container -->
        <div class="layout-page">
  
          <!-- Content wrapper -->
            @yield('content')
          <!-- Content wrapper -->
          
        </div>
        <!-- / Layout page -->
      </div>
  
      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('backend/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('backend/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('backend/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('backend/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('backend/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('backend/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    @stack('ckeditor')
    @stack('scripts')
    {{-- @stack('script') --}}
   </body>
</html>