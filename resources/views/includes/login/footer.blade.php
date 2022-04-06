 <!-- Footer Start -->
    <footer class="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <script>
              document.write(new Date().getFullYear());
            </script>
            &copy; {{session('copyright')}} 
            {{-- <a href="">Coderthemes</a> --}}
          </div>
          <div class="col-md-6">
            <div class="text-md-right footer-links d-none d-sm-block">
              <a href="javascript:void(0);">Version {{session('version_name')}}</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- end Footer -->