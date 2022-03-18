<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      content="A fully featured admin theme which can be used to build CRM, CMS, etc."
      name="description"
    />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>@yield('title')</title>

    {{-- style --}}
    @stack('prepend-style')

    @include('includes.mata_kuliah.style')

    @stack('addon-style')

  </head>

  <body>
    <header class="sticky">
    @include('includes.mata_kuliah.header')
    
    </header>

    {{-- Page Content --}}
    @yield('content')

  
    {{-- Footer --}}
    @include('includes.mata_kuliah.footer')


    {{-- Script --}}
    @stack('prepend-script')

    @include('includes.mata_kuliah.script')

    @stack('addon-script')

   
  </body>
</html>
