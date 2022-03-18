  <!-- footer start -->
    <footer class="bg-dark py-5 footer text-white">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="mb-3">
              <img src="landing/images/logo-light.png" alt="" height="20" />
            </div>
            <p class="pt-1 text-white-50">
              Sistem Informasi {{session("applicationName")}}
            </p>
            <p class="text-white-50">
             {{session("desc")}}
            </p>
          </div>
          <div class="col-lg-2 offset-lg-1">
            <h5 class="footer-title text-white mb-3">About</h5>
            <ul class="list-unstyled footer-list">
              <li><a href="">Home</a></li>
              <li><a href="">Features</a></li>
              <li><a href="">About Us</a></li>
              <li><a href="">FAQ</a></li>
            </ul>
          </div>
          <div class="col-lg-2">
            <h5 class="footer-title text-white mb-3">Support</h5>
            <ul class="list-unstyled footer-list">
              <li><a href="">Help & Support</a></li>
              <li><a href="">Privacy Policy</a></li>
              <li><a href="">Terms & Conditions</a></li>
            </ul>
          </div>
          <div class="col-lg-3">
            <h5 class="footer-title text-white mb-3">Contact</h5>
            <div class="pt-1">
              <div class="float-left mr-2">
                <i class="pe-7s-map-marker font-20"></i>
              </div>
              <p class="text-white-50 overflow-hidden">
                {{session("alamat")}}
              </p>
            </div>
            <div>
              <div class="float-left mr-2">
                <i class="pe-7s-phone font-20"></i>
              </div>
              <p class="text-white-50 overflow-hidden">{{session("telp")}}</p>
            </div>
            <div>
              <div class="float-left mr-2">
                <i class="pe-7s-mail font-20"></i>
              </div>
              <p class="text-white-50 overflow-hidden">{{session("email")}}</p>
            </div>
          </div>
        </div>
        <!-- end row -->
        <div class="row">
          <div class="col-lg-12">
            <div class="pt-4">
              <div class="text-center">
                <p class="text-white-50 mb-0">
                  2020 - 2024 © {{session("copyright")}}
                  {{-- <a
                    href="https://coderthemes.com/"
                    target="_blank"
                    class="text-white-50"
                    >Coderthemes</a
                  > --}}
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
      <!-- container end -->
    </footer>
    <!-- footer end -->