<!-- Left Sidebar Start -->
<div class="app-sidebar-menu">
    <!-- Logo Box -->
    <div class="logo-box">
        <a href="{{ route('dashboard') }}" class="logo logo-light d-flex align-items-center">
            <span class="logo-sm">
                <img src="/images/logo.png" alt="Small Logo">
            </span>
            <span class="logo-lg">
                <img src="/images/logo.png" alt="Large Logo">
            </span>
            <span class="logo-text ms-2">Royal Butcher</span>
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-dark d-flex align-items-center">
            <span class="logo-sm">
                <img src="/images/logo.png" alt="Small Logo">
            </span>
            <span class="logo-lg">
                <img src="/images/logo.png" alt="Large Logo">
            </span>
            <span class="logo-text ms-2">Royal Butcher</span>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu" style="padding: 0px 2px 0px 2px;">

            <!-- Custom styling for sidebar buttons -->
            <style>
                /* Logo Box Styling */
                .logo-box {
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                    padding: 1rem !important;
                }

                .logo-box .logo {
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                    text-decoration: none;
                    width: 100%;
                }

                .logo-box .logo img {
                    max-width: 100%;
                    height: auto;
                    object-fit: contain;
                    flex-shrink: 0;
                }

                .logo-box .logo-lg img {
                    max-height: 60px;
                    width: auto;
                }

                .logo-box .logo-sm img {
                    max-height: 40px;
                    width: auto;
                }

                .logo-box .logo-text {
                    font-size: 1.25rem;
                    font-weight: 600;
                    color: #212529;
                    white-space: nowrap;
                    margin-left: 0.75rem;
                }

                body[data-menu-color="dark"] .logo-box .logo-text {
                    color: #fff;
                }

                /* Hide logo-light by default, show logo-dark */
                .logo-box .logo-light {
                    display: none !important;
                }

                .logo-box .logo-dark {
                    display: flex !important;
                }

                /* Show logo-light only in dark mode */
                body[data-menu-color="dark"] .logo-box .logo-light {
                    display: flex !important;
                }

                body[data-menu-color="dark"] .logo-box .logo-dark {
                    display: none !important;
                }

                /* Ensure only one logo span shows at a time */
                .logo-box .logo-lg {
                    display: block;
                }

                .logo-box .logo-sm {
                    display: none;
                }

                @media (max-width: 991.98px) {
                    .logo-box .logo-lg {
                        display: none !important;
                    }

                    .logo-box .logo-sm {
                        display: block !important;
                    }

                    .logo-box .logo-text {
                        font-size: 1rem;
                    }
                }

                /* Main sidebar pill buttons */
                #side-menu.nav-pills .nav-link {
                    padding-top: 0.8rem;
                    padding-bottom: 0.8rem;
                    border-radius: 0.375rem;
                    font-weight: 500;
                    color: #495057;
                    transition: all 0.2s ease-in-out;
                    position: relative;
                }

                /* Hover effect for non-active buttons */
                #side-menu.nav-pills .nav-link:not(.active):hover {
                    background-color: #e9ecef;
                }

                /* Active button style */
                #side-menu.nav-pills .nav-link.active {
                    background-color: #0d6efd;
                    color: #fff;
                    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
                }

                /* Sub-menu links */
                #side-menu .nav-second-level .nav-link {
                    padding-top: 0.6rem;
                    padding-bottom: 0.6rem;
                    font-weight: normal;
                }

                /* Active sub-menu link */
                #side-menu .nav-second-level .nav-link.active {
                    background-color: transparent;
                    color: #0d6efd;
                    font-weight: 500;
                    box-shadow: none;
                }

                /* Hover sub-menu link */
                #side-menu .nav-second-level .nav-link:not(.active):hover {
                    background-color: #f8f9fa;
                    color: #000;
                }

                /* Arrow animation */
                .menu-arrow {
                    transition: transform 0.15s ease;
                    display: inline-block;
                    font-family: 'Material Design Icons';
                    text-rendering: auto;
                    font-size: 1.1rem;
                    margin-left: auto;
                    /* Pushes arrow to the right if not using justify-content-between, but safe to have */
                }

                .menu-arrow:before {
                    content: "\F0142";
                }

                a[aria-expanded="true"] .menu-arrow,
                li>a[aria-expanded="true"]>span.menu-arrow {
                    transform: rotate(90deg);
                }
            </style>

            <ul class="nav flex-column nav-pills px-3" id="side-menu">

                <!-- Menu Title -->
                <li class="nav-item">
                    <h6 class="nav-link text-muted text-uppercase small mt-2 mb-1">Menu</h6>
                </li>

                <!-- Dashboard Link -->
                <li class="nav-item my-1">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i data-feather="home" class="me-2" style="width: 18px;"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <!-- Pages Title -->
                <li class="nav-item">
                    <h6 class="nav-link text-muted text-uppercase small mt-3 mb-1">Pages</h6>
                </li>

                <!-- Profile Link -->
                <li class="nav-item my-1">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('profile') ? 'active' : '' }}"
                        href="{{ route('profile') }}">
                        <i data-feather="file-text" class="me-2" style="width: 18px;"></i>
                        <span> Profile </span>
                    </a>
                </li>

                <!-- Category Link -->
                <li class="nav-item my-1">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">
                        <i data-feather="grid" class="me-2" style="width: 18px;"></i>
                        <span> Categories </span>
                    </a>
                </li>

                <!-- Items Link -->
                <li class="nav-item my-1">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('items.*') ? 'active' : '' }}"
                        href="{{ route('items.index') }}">
                        <i data-feather="box" class="me-2" style="width: 18px;"></i>
                        <span> Items </span>
                    </a>
                </li>

                <!-- --- Orders Link --- -->
                <li class="nav-item my-1">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                        href="{{ route('orders.index') }}">
                        <i data-feather="shopping-cart" class="me-2" style="width: 18px;"></i>
                        <span> Orders </span>
                    </a>
                </li>

                <!-- ==== DYNAMIC CONTENT DROPDOWN (FIXED UI) ==== -->
                <li class="nav-item my-1">
                    <!-- Dropdown Toggle Link -->
                    @php
                        // --- UPDATED: 'new-order-pages.*' add karein ---
                        $contentRoutes = [
                            'splash-screens.*',
                            'select-city-pages.*',
                            'phone-number-pages.*',
                            'otp-pages.*',
                            'home-page-contents.*',
                            'new-order-pages.*',
                            'order-customization-pages.*',
                            'cart-page-contents.*',
                            'checkout-page-contents.*',
                            'add-address-pages.*',
                            'access-location-pages.*',
                            'profile-pages.*',
                            'card-details-pages.*',
                            'successful-pages.*',
                            'drawer-pages.*',
                            'wallet-pages.*',
                            'change-information-pages.*',
                            'personal-information-pages.*',
                            'signup-pages.*',
                            'signin-pages.*',
                            'forgot-password-pages.*'
                        ];
                    @endphp
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs($contentRoutes) ? 'active' : '' }}"
                        href="#sidebarContent" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs($contentRoutes) ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <i data-feather="edit" class="me-2" style="width: 18px;"></i>
                            <span> Dynamic Content </span>
                        </div>
                        <span class="menu-arrow"></span>
                    </a>

                    <!-- Collapsible Sub-menu -->
                    <div class="collapse {{ request()->routeIs($contentRoutes) ? 'show' : '' }}" id="sidebarContent">
                        <ul class="nav flex-column ps-4 nav-second-level">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('splash-screens.*') ? 'active' : '' }}"
                                    href="{{ route('splash-screens.index') }}">
                                    <span>Splash Screen</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('select-city-pages.*') ? 'active' : '' }}"
                                    href="{{ route('select-city-pages.index') }}">
                                    <span>Select City Page</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('phone-number-pages.*') ? 'active' : '' }}"
                                    href="{{ route('phone-number-pages.index') }}">
                                    <span>Phone Number Page</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('otp-pages.*') ? 'active' : '' }}"
                                    href="{{ route('otp-pages.index') }}">
                                    <span>OTP Page</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('profile-pages.*') ? 'active' : '' }}"
                                    href="{{ route('profile-pages.index') }}">
                                    <span>Profile Page</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home-page-contents.*') ? 'active' : '' }}"
                                    href="{{ route('home-page-contents.index') }}">
                                    <span>Home Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: New Order Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('new-order-pages.*') ? 'active' : '' }}"
                                    href="{{ route('new-order-pages.index') }}">
                                    <span>New Order Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Order Customization Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('order-customization-pages.*') ? 'active' : '' }}"
                                    href="{{ route('order-customization-pages.index') }}">
                                    <span>Order Customization Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Cart Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('cart-page-contents.*') ? 'active' : '' }}"
                                    href="{{ route('cart-page-contents.index') }}">
                                    <span>Cart Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Checkout Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('checkout-page-contents.*') ? 'active' : '' }}"
                                    href="{{ route('checkout-page-contents.index') }}">
                                    <span>Checkout Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Add Address Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('add-address-pages.*') ? 'active' : '' }}"
                                    href="{{ route('add-address-pages.index') }}">
                                    <span>Add Address Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Access Location Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('access-location-pages.*') ? 'active' : '' }}"
                                    href="{{ route('access-location-pages.index') }}">
                                    <span>Access Location Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Card Details Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('card-details-pages.*') ? 'active' : '' }}"
                                    href="{{ route('card-details-pages.index') }}">
                                    <span>Card Details Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Successful Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('successful-pages.*') ? 'active' : '' }}"
                                    href="{{ route('successful-pages.index') }}">
                                    <span>Successful Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Drawer Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('drawer-pages.*') ? 'active' : '' }}"
                                    href="{{ route('drawer-pages.index') }}">
                                    <span>Drawer Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Wallet Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('wallet-pages.*') ? 'active' : '' }}"
                                    href="{{ route('wallet-pages.index') }}">
                                    <span>Wallet Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Change Information Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('change-information-pages.*') ? 'active' : '' }}"
                                    href="{{ route('change-information-pages.index') }}">
                                    <span>Change Information Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Personal Information Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('personal-information-pages.*') ? 'active' : '' }}"
                                    href="{{ route('personal-information-pages.index') }}">
                                    <span>Personal Information Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Signup Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('signup-pages.*') ? 'active' : '' }}"
                                    href="{{ route('signup-pages.index') }}">
                                    <span>Signup Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Signin Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('signin-pages.*') ? 'active' : '' }}"
                                    href="{{ route('signin-pages.index') }}">
                                    <span>Signin Page</span>
                                </a>
                            </li>
                            <!-- --- NEW: Forgot Password Page Link --- -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('forgot-password-pages.*') ? 'active' : '' }}"
                                    href="{{ route('forgot-password-pages.index') }}">
                                    <span>Forgot Password Page</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <!-- ==== END DYNAMIC CONTENT ==== -->

                <!-- User Management Dropdown (Spatie Permission Check) -->
                @can('admin')
                    <li class="nav-item my-1">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('user-management.*', 'role-management.*') ? 'active' : '' }}"
                            href="#sidebarUserMgmt" data-bs-toggle="collapse" role="button"
                            aria-expanded="{{ request()->routeIs('user-management.*', 'role-management.*') ? 'true' : 'false' }}">
                            <div class="d-flex align-items-center">
                                <i data-feather="users" class="me-2" style="width: 18px;"></i>
                                <span> User Management </span>
                            </div>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="collapse {{ request()->routeIs('user-management.*', 'role-management.*') ? 'show' : '' }}"
                            id="sidebarUserMgmt">
                            <ul class="nav flex-column ps-4 nav-second-level">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user-management.index') ? 'active' : '' }}"
                                        href="{{ route('user-management.index') }}">
                                        <span>Users List</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('role-management.index') ? 'active' : '' }}"
                                        href="{{ route('role-management.index') }}">
                                        <span>Roles</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->