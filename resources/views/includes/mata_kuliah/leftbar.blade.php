
<!-- Left Sidebar -->
 <aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="assets/images/xs/avatar1.jpg" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown">{{Auth::user()->name}}</div>                
            <div class="btn-group user-helper-dropdown"> <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="button"> keyboard_arrow_down </i>
                <ul class="dropdown-menu slideUp">
                    {{-- <li><a href="profile.html"><i class="material-icons">person</i>Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                    <li class="divider"></li> --}}
                    <li> <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>{{ __('Logout') }}
                        </a></li>
                </ul>
            </div>
            <div class="email">email : tik@unm.ac.id </div>
        </div>
    </div>
    <!-- #User Info --> 
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            {{-- <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
                <ul class="ml-menu">
                    <li><a href="index.html">Main Dashboard</a> </li>
                    <li><a href="dashboard-rtl.html">RTL Dashboard</a></li>
                    <li><a href="index2.html">Horizontal Menu</a></li>
                    <li><a href="blog-dashboard.html">Blog Dashboard</a></li>
                    <li><a href="ec-dashboard.html">Ecommerce Dashboard</a></li>                        
                </ul>
            </li> --}}
            <li class="active"> <a href="aplikasi"><i class="zmdi zmdi-delicious"></i><span>Aplikasi</span> </a> </li>
            {{-- <li class="active open"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Ecommerce</span> </a>
                <ul class="ml-menu">
                    <li> <a href="ec-dashboard.html">Dashboard</a></li>
                    <li class="active"> <a href="ec-product.html">Product</a></li>
                    <li> <a href="ec-product-List.html">Product List</a></li>
                    <li> <a href="ec-product-detail.html">Product detail</a></li>
                </ul>
            </li> --}}
        </ul>
    </div>
    <!-- #Menu --> 
</aside>   