<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('asset/images/logo.png')}}" class="img-fluid" alt=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('about')}}">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('product')}}">
                                    Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('services')}}">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('contact')}}">Contact</a>
                            </li>
                        </ul>
                        <form action="{{ route('product') }}" method="GET" class="d-flex side-top align-items-center">
                            <div class="top-icon">
                                <input class="form-control" type="search" name="search" value="{{ request('search') }}" placeholder="Search..." aria-label="Search">
                                <button type="submit" class="icon-menu border-0 p-0" style="position: absolute; z-index: 2; top: 2px; right: 6px;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                            <!-- Side Cart Trigger -->
                            <a href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" class="position-relative text-decoration-none ms-2">
                                <span class="icon-menu"><i class="fa-solid fa-cart-shopping"></i></span>
                                <span class="badge rounded-pill bg-danger cart-count-badge" id="cartCountBadge" style="position: absolute; top: -5px; right: -5px; font-size: 0.65rem; padding: 3px 6px;">
                                    {{ count(session('cart', [])) }}
                                </span>
                            </a>
                            <!-- User Account Dropdown -->
                            <div class="dropdown d-inline-block ms-2">
                                <a href="javascript:;" class="text-decoration-none dropdown-toggle-custom" id="headerUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="icon-menu"><i class="fa-regular fa-circle-user"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="headerUserDropdown" style="min-width: 200px; border-radius: 8px;">
                                    @auth
                                        <li class="px-3 py-2 bg-light rounded-top">
                                            <span class="d-block text-muted small">Signed in as</span>
                                            <strong class="text-dark text-truncate d-block">{{ Auth::user()->name }}</strong>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        @if(in_array(Auth::user()->role, [1]))
                                            <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-2 text-primary"></i>Admin Panel</a></li>
                                        @else
                                            <li><a class="dropdown-item py-2" href="{{ route('account') }}"><i class="fa-solid fa-user me-2 text-primary"></i>My Account</a></li>
                                        @endif
                                        <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                                    @else
                                        <li><a class="dropdown-item py-2 fw-semibold" href="{{ route('signin') }}"><i class="fa-solid fa-right-to-bracket me-2 text-primary"></i>Sign In</a></li>
                                        <li><a class="dropdown-item py-2 fw-semibold" href="{{ route('signup') }}"><i class="fa-solid fa-user-plus me-2 text-success"></i>Sign Up</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>