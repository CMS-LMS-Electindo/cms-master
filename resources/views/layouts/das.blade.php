<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free."
    />
    <meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    {{-- style --}}
    @stack('prepend-style')

    @include('includes.admin.style')

    @stack('addon-style')

  </head>

  

  <body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="page d-flex flex-row flex-column-fluid">
          <!--begin::Aside-->
        @include('includes.admin.leftbar')
          
          <!--end::Aside-->
          <!--begin::Wrapper-->
          <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
              <!--begin::Header-->
              
              @include('includes.admin.topbar')
              <!--end::Header-->
              <!--begin::Content-->
              <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                
              @include('includes.admin.toolbar')

              @yield('content')
              </div>
              
              <!--end::Content-->
              <!--begin::Footer-->
              @include('includes.admin.footer')
              
              <!--end::Footer-->
          </div>
          <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>  
    @include('includes.admin.rightbar')
    
    @stack('prepend-script')

    @include('includes.admin.script')

    @stack('addon-script')

  </body>
</html>
