      <div class="left-side-menu">
        <!-- LOGO -->
        <div class="logo-box">
          <a href="dashboard" class="logo logo-dark text-center">
            <span class="logo-sm">
              <img src="assets/images/logo-sm-dark.png" alt="" height="24" />
              <!-- <span class="logo-lg-text-light">Minton</span> -->
            </span>
            <span class="logo-lg">
              <img src="assets/images/logo-dark.png" alt="" height="20" />
              <!-- <span class="logo-lg-text-light">M</span> -->
            </span>
          </a>

          <a href="dashboard" class="logo logo-light text-center">
            <span class="logo-sm">
              <img src="assets/images/logo-sm.png" alt="" height="24" />
            </span>
            <span class="logo-lg">
              <img src="assets/images/logo-light.png" alt="" height="20" />
            </span>
          </a>
        </div>

        <div class="h-100" data-simplebar>
          <!-- User box -->
          <div class="user-box text-center">
            <img
              src="{{session("foto")}}"
              alt="user-img"
              title="Mat Helme"
              class="rounded-circle avatar-md"
            />
            <div class="dropdown">
              <a
                href="javascript: void(0);"
                class="text-reset dropdown-toggle h5 mt-2 mb-1 d-block font-weight-medium"
                data-toggle="dropdown"
                >{{Auth::user()->name}}</a
              >
              <div class="dropdown-menu user-pro-dropdown">
                <!-- item-->
                <a href="profil" class="dropdown-item notify-item">
                  <i class="fe-user mr-1"></i>
                  <span>My Account</span>
                </a>

                <!-- item-->
                {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i class="fe-settings mr-1"></i>
                  <span>Settings</span>
                </a> --}}

                <!-- item-->
                <a href="change-password" class="dropdown-item notify-item">
                  <i class="fe-lock mr-1"></i>
                  <span>Change Password</span>
                </a>

                <!-- item-->
                {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i class="fe-log-out mr-1"></i>
                  <span>Logout</span>
                </a> --}}
              </div>
            </div>
            <p class="text-reset">Admin Head</p>
          </div>

          <!--- Sidemenu -->
          <div id="sidebar-menu">
            <ul id="side-menu">
              <li class="menu-title">Navigation</li>
              {{-- <li>
                <a href="dashboard">
                  <i class="ri-dashboard-line"></i>
                  <span> Dashboard </span>
                </a>
              </li> --}}
              <li>
                <a href="dashboard" >
                  <i class="ri-dashboard-line"></i>
                  {{-- <span class="badge badge-success badge-pill float-right">3</span> --}}
                  <span> Dashboards </span>
                </a>
              </li>

              <li>
                <a href="#sidebarLayouts" data-toggle="collapse">
                  <i class="ri-layout-line"></i>
                  <span> Master Data </span>
                  <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <ul class="nav-second-level">
                    <li>
                      <a href="dosen">Dosen</a>
                    </li>
                    <li>
                      <a href="kurikulum">Kurikulum</a>
                    </li>
                    <li>
                      <a href="mata-kuliah">Mata Kuliah</a>
                    </li>
                    <li>
                      <a href="universitas">Universitas</a>
                    </li>
                    <li>
                      <a href="fakultas">Fakultas</a>
                    </li>
                    <li>
                      <a href="jurusan">Jurusan</a>
                    </li>
                    <li>
                      <a href="program-studi">Program Studi</a>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="menu-title mt-2">Apps</li>

              <li>
                <a href="matakuliah">
                  <i class="ri-book-open-fill"></i>
                  <span> Mata Kuliah </span>
                </a>
              </li>
              <li>
                <a href="validasi-mata-kuliah">
                  <i class="ri-file-mark-line"></i>
                  <span> Validasi Mata Kuliah </span>
                </a>
              </li>
              {{-- <li>
                <a href="berita-acara">
                  <i class="ri-tv-2-line"></i>
                  <span> Berita Acara </span>
                </a>
              </li> --}}

              {{-- <li>
                <a href="#sidebarEcommerce" data-toggle="collapse">
                  <i class="ri-shopping-cart-2-line"></i>
                  <span class="badge badge-danger float-right">New</span>
                  <span> Berita Acara </span>
                </a>
                <div class="collapse" id="sidebarEcommerce">
                  <ul class="nav-second-level">
                    <li>
                      <a href="ecommerce-products.html">Products List</a>
                    </li>
                    <li>
                      <a href="ecommerce-products-grid.html">Products Grid</a>
                    </li>
                    <li>
                      <a href="ecommerce-product-detail.html">Product Detail</a>
                    </li>
                    <li>
                      <a href="ecommerce-product-create.html">Create Product</a>
                    </li>
                    <li>
                      <a href="ecommerce-customers.html">Customers</a>
                    </li>
                    <li>
                      <a href="ecommerce-orders.html">Orders</a>
                    </li>
                    <li>
                      <a href="ecommerce-orders-detail.html">Order Detail</a>
                    </li>
                    <li>
                      <a href="ecommerce-sellers.html">Sellers</a>
                    </li>
                    <li>
                      <a href="ecommerce-cart.html">Shopping Cart</a>
                    </li>
                    <li>
                      <a href="ecommerce-checkout.html">Checkout</a>
                    </li>
                  </ul>
                </div>
              </li> --}}

              {{-- <li>
                <a href="kuitansi">
                  <i class="ri-calendar-2-line"></i>
                  <span> Kuitansi </span>
                </a>
              </li>
              <li>
                <a href="statistik">
                  <i class="ri-database-2-fill"></i>
                  <span> Statistik </span>
                </a>
              </li> --}}
            </ul>
          </div>
          <!-- End Sidebar -->
          <div class="clearfix"></div>
        </div>
        <!-- Sidebar -left -->
      </div>