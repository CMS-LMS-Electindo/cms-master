<div class="tagline d-none d-lg-block bg-dark" style="position: unset;">
    <div class="container">
        <div class="float-left info-link">
        <ul class="list-inline mb-0">
            <li class="list-inline-item">
            <i class="mdi mdi-phone-classic mr-1"></i>
            <span class="font-size-13">{{session('telp')}}</span>
            </li>
            <li class="list-inline-item">
            <a href="#">
                <i class="mdi mdi-email mr-1"></i>
                <span class="font-size-13">{{session('email')}}</span>
            </a>
            </li>
        </ul>
        </div>
        <div class="float-right">
        <ul class="list-inline social-links mb-0">
            <li class="list-inline-item">
            <a href="#">
                <i class="mdi mdi-facebook"></i>
            </a>
            </li>
            <li class="list-inline-item">
            <a href="#">
                <i class="mdi mdi-twitter"></i>
            </a>
            </li>
            <li class="list-inline-item">
            <a href="#">
                <i class="mdi mdi-linkedin"></i>
            </a>
            </li>
            <li class="list-inline-item">
            <a href="#">
                <i class="mdi mdi-pinterest"></i>
            </a>
            </li>
            <li class="list-inline-item">
            <a href="#">
                <i class="mdi mdi-instagram"></i>
            </a>
            </li>
        </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    </div>

    <!--Navbar Start-->
    <nav
    class="navbar navbar-expand-lg fixed-top navbar-custom navbar-light"
    id="navbar">
    <div class="container">
        <!-- LOGO -->
        <a class="logo text-uppercase" href="index.html">
        <img
            src="landing/images/logo-dark.png"
            alt=""
            class="logo-light"
            height="20"
        />
        <img
            src="landing/images/logo-dark.png"
            alt=""
            class="logo-dark"
            height="20"
        />
        </a>

        <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarCollapse"
        aria-controls="navbarCollapse"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        <i class="mdi mdi-menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto navbar-center" id="mySidenav">
            <li class="nav-item active">
            <a href="home#home" class="nav-link">Home</a>
            </li>
            <!-- <li class="nav-item">
            <a href="#services" class="nav-link">Services</a>
            </li> -->
            <li class="nav-item">
            <a href="home#features" class="nav-link">Mata Kuliah</a>
            </li>
            {{-- <li class="nav-item">
            <a href="#pricing" class="nav-link">Genap</a>
            </li> --}}
            <li class="nav-item">
            <a href="home#login" class="nav-link">Login</a>
            </li>
        </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->