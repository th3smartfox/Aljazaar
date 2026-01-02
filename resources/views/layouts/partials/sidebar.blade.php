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
        <div id="sidebar-menu">

            <!-- TailAdmin-inspired Styling for Bootstrap -->
            <style>
                /* ========== TAILADMIN SIDEBAR STYLES ========== */
                :root {
                    --ta-brand-50: #ecf3ff;
                    --ta-brand-100: #dde9ff;
                    --ta-brand-500: #465fff;
                    --ta-brand-600: #3641f5;
                    --ta-gray-50: #f9fafb;
                    --ta-gray-100: #f2f4f7;
                    --ta-gray-200: #e4e7ec;
                    --ta-gray-300: #d0d5dd;
                    --ta-gray-400: #98a2b3;
                    --ta-gray-500: #667085;
                    --ta-gray-600: #475467;
                    --ta-gray-700: #344054;
                    --ta-gray-800: #1d2939;
                }

                /* Logo Box Styling */
                .logo-box {
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                    padding: 1.5rem 1rem 1.25rem !important;
                    border-bottom: 1px solid var(--ta-gray-200);
                    margin-bottom: 0.5rem;
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
                    max-height: 36px;
                    width: auto;
                }

                .logo-box .logo-sm img {
                    max-height: 28px;
                    width: auto;
                }

                .logo-box .logo-text {
                    font-size: 1.125rem;
                    font-weight: 600;
                    color: var(--ta-gray-800);
                    white-space: nowrap;
                    margin-left: 0.5rem;
                }

                body[data-menu-color="dark"] .logo-box {
                    border-bottom-color: rgba(255, 255, 255, 0.1);
                }

                body[data-menu-color="dark"] .logo-box .logo-text {
                    color: #fff;
                }

                .logo-box .logo-light { display: none !important; }
                .logo-box .logo-dark { display: flex !important; }
                body[data-menu-color="dark"] .logo-box .logo-light { display: flex !important; }
                body[data-menu-color="dark"] .logo-box .logo-dark { display: none !important; }
                .logo-box .logo-lg { display: block; }
                .logo-box .logo-sm { display: none; }

                @media (max-width: 991.98px) {
                    .logo-box .logo-lg { display: none !important; }
                    .logo-box .logo-sm { display: block !important; }
                    .logo-box .logo-text { font-size: 1rem; }
                }

                /* Sidebar Menu Container */
                #sidebar-menu {
                    padding: 0 0.75rem;
                }

                /* Menu Group Title */
                .ta-menu-title {
                    font-size: 0.6875rem;
                    font-weight: 600;
                    letter-spacing: 0.05em;
                    text-transform: uppercase;
                    color: var(--ta-gray-400);
                    padding: 0.875rem 0.75rem 0.5rem;
                    margin-bottom: 0;
                    line-height: 1.25rem;
                }

                /* Menu Items List */
                .ta-menu {
                    list-style: none;
                    padding: 0;
                    margin: 0 0 0.5rem;
                    display: flex;
                    flex-direction: column;
                    gap: 2px;
                }

                /* Menu Item Link */
                .ta-menu-item {
                    position: relative;
                    display: flex;
                    align-items: center;
                    width: 100%;
                    gap: 0.625rem;
                    padding: 0.5rem 0.75rem;
                    font-size: 0.8125rem;
                    font-weight: 500;
                    color: var(--ta-gray-700);
                    text-decoration: none;
                    border-radius: 0.5rem;
                    transition: all 0.15s ease-in-out;
                    border: none;
                    background: transparent;
                    text-align: left;
                    cursor: pointer;
                }

                .ta-menu-item:hover {
                    background-color: var(--ta-gray-100);
                    color: var(--ta-gray-700);
                    text-decoration: none;
                }

                .ta-menu-item.active {
                    background-color: var(--ta-brand-50);
                    color: var(--ta-brand-500);
                }

                .ta-menu-item.active:hover {
                    background-color: var(--ta-brand-100);
                }

                /* Menu Item Icon */
                .ta-menu-item svg,
                .ta-menu-item i {
                    width: 18px;
                    height: 18px;
                    flex-shrink: 0;
                    color: var(--ta-gray-500);
                    transition: color 0.15s ease-in-out;
                }

                .ta-menu-item:hover svg,
                .ta-menu-item:hover i {
                    color: var(--ta-gray-700);
                }

                .ta-menu-item.active svg,
                .ta-menu-item.active i {
                    color: var(--ta-brand-500);
                }

                /* Menu Item Text */
                .ta-menu-item span:not(.ta-menu-arrow) {
                    flex: 1;
                }

                /* Dropdown Arrow */
                .ta-menu-arrow {
                    width: 18px;
                    height: 18px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: transform 0.2s ease;
                    margin-left: auto;
                    flex-shrink: 0;
                }

                .ta-menu-arrow svg {
                    width: 14px;
                    height: 14px;
                    color: var(--ta-gray-400);
                }

                .ta-menu-item[aria-expanded="true"] .ta-menu-arrow {
                    transform: rotate(180deg);
                }

                .ta-menu-item[aria-expanded="true"] .ta-menu-arrow svg,
                .ta-menu-item.active .ta-menu-arrow svg {
                    color: var(--ta-brand-500);
                }

                /* Submenu Container */
                .ta-submenu {
                    list-style: none;
                    padding: 0.25rem 0 0.25rem 0;
                    margin: 0.25rem 0 0.25rem 1rem;
                    display: flex;
                    flex-direction: column;
                    gap: 1px;
                    border-left: 1.5px solid var(--ta-gray-200);
                }

                /* Submenu Item */
                .ta-submenu-item {
                    position: relative;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    padding: 0.375rem 0.75rem;
                    margin-left: 0.75rem;
                    font-size: 0.8125rem;
                    font-weight: 500;
                    color: var(--ta-gray-600);
                    text-decoration: none;
                    border-radius: 0.375rem;
                    transition: all 0.15s ease-in-out;
                }

                .ta-submenu-item:hover {
                    background-color: var(--ta-gray-100);
                    color: var(--ta-gray-700);
                    text-decoration: none;
                }

                .ta-submenu-item.active {
                    background-color: var(--ta-brand-50);
                    color: var(--ta-brand-500);
                    font-weight: 600;
                }

                /* Submenu Group Label */
                .ta-submenu-group {
                    font-size: 0.625rem;
                    font-weight: 600;
                    letter-spacing: 0.04em;
                    text-transform: uppercase;
                    color: var(--ta-gray-400);
                    padding: 0.5rem 0.75rem 0.25rem;
                    margin-left: 0.75rem;
                    margin-top: 0.375rem;
                }

                .ta-submenu-group:first-child {
                    margin-top: 0;
                }

                /* Dark Mode Adjustments */
                body[data-menu-color="dark"] .ta-menu-title {
                    color: var(--ta-gray-400);
                }

                body[data-menu-color="dark"] .ta-menu-item {
                    color: #d0d5dd;
                }

                body[data-menu-color="dark"] .ta-menu-item:hover {
                    background-color: rgba(255, 255, 255, 0.05);
                    color: #d0d5dd;
                }

                body[data-menu-color="dark"] .ta-menu-item.active {
                    background-color: rgba(70, 95, 255, 0.12);
                    color: #7592ff;
                }

                body[data-menu-color="dark"] .ta-menu-item svg,
                body[data-menu-color="dark"] .ta-menu-item i {
                    color: var(--ta-gray-400);
                }

                body[data-menu-color="dark"] .ta-menu-item:hover svg,
                body[data-menu-color="dark"] .ta-menu-item:hover i {
                    color: #d0d5dd;
                }

                body[data-menu-color="dark"] .ta-menu-item.active svg,
                body[data-menu-color="dark"] .ta-menu-item.active i {
                    color: #7592ff;
                }

                body[data-menu-color="dark"] .ta-submenu {
                    border-left-color: rgba(255, 255, 255, 0.1);
                }

                body[data-menu-color="dark"] .ta-submenu-item {
                    color: var(--ta-gray-300);
                }

                body[data-menu-color="dark"] .ta-submenu-item:hover {
                    background-color: rgba(255, 255, 255, 0.05);
                    color: #d0d5dd;
                }

                body[data-menu-color="dark"] .ta-submenu-item.active {
                    background-color: rgba(70, 95, 255, 0.12);
                    color: #7592ff;
                }

                body[data-menu-color="dark"] .ta-submenu-group {
                    color: var(--ta-gray-500);
                }
            </style>

            <!-- ========== MAIN MENU ========== -->
            <h2 class="ta-menu-title">Main</h2>
            <ul class="ta-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="ta-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- ========== SHOP ========== -->
            <h2 class="ta-menu-title">Shop</h2>
            @php $shopRoutes = ['categories.*', 'items.*', 'orders.*', 'chat.*']; @endphp
            <ul class="ta-menu">
                <li>
                    <button class="ta-menu-item {{ request()->routeIs($shopRoutes) ? 'active' : '' }}"
                        data-bs-toggle="collapse" data-bs-target="#shopMenu" aria-expanded="{{ request()->routeIs($shopRoutes) ? 'true' : 'false' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Shop Management</span>
                        <span class="ta-menu-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </button>
                    <div class="collapse {{ request()->routeIs($shopRoutes) ? 'show' : '' }}" id="shopMenu">
                        <ul class="ta-submenu">
                            <li><a href="{{ route('categories.index') }}" class="ta-submenu-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">Categories</a></li>
                            <li><a href="{{ route('items.index') }}" class="ta-submenu-item {{ request()->routeIs('items.*') ? 'active' : '' }}">Items</a></li>
                            <li><a href="{{ route('orders.index') }}" class="ta-submenu-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">Orders</a></li>
                            <li><a href="{{ route('chat.index') }}" class="ta-submenu-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">Chat</a></li>
                        </ul>
                    </div>
                </li>
            </ul>

            <!-- ========== FINANCE ========== -->
            <h2 class="ta-menu-title">Finance</h2>
            <ul class="ta-menu">
                <!-- Subscriptions -->
                @php $subscriptionRoutes = ['subscription-plans.*', 'user-subscriptions.*']; @endphp
                <li>
                    <button class="ta-menu-item {{ request()->routeIs($subscriptionRoutes) ? 'active' : '' }}"
                        data-bs-toggle="collapse" data-bs-target="#subscriptionMenu" aria-expanded="{{ request()->routeIs($subscriptionRoutes) ? 'true' : 'false' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        <span>Subscriptions</span>
                        <span class="ta-menu-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </button>
                    <div class="collapse {{ request()->routeIs($subscriptionRoutes) ? 'show' : '' }}" id="subscriptionMenu">
                        <ul class="ta-submenu">
                            <li><a href="{{ route('subscription-plans.index') }}" class="ta-submenu-item {{ request()->routeIs('subscription-plans.*') ? 'active' : '' }}">Plans</a></li>
                            <li><a href="{{ route('user-subscriptions.index') }}" class="ta-submenu-item {{ request()->routeIs('user-subscriptions.*') ? 'active' : '' }}">User Subscriptions</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Wallet -->
                @php $walletRoutes = ['wallets.*', 'wallet-transactions.*']; @endphp
                <li>
                    <button class="ta-menu-item {{ request()->routeIs($walletRoutes) ? 'active' : '' }}"
                        data-bs-toggle="collapse" data-bs-target="#walletMenu" aria-expanded="{{ request()->routeIs($walletRoutes) ? 'true' : 'false' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>Wallet</span>
                        <span class="ta-menu-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </button>
                    <div class="collapse {{ request()->routeIs($walletRoutes) ? 'show' : '' }}" id="walletMenu">
                        <ul class="ta-submenu">
                            <li><a href="{{ route('wallets.index') }}" class="ta-submenu-item {{ request()->routeIs('wallets.*') ? 'active' : '' }}">All Wallets</a></li>
                            <li><a href="{{ route('wallet-transactions.index') }}" class="ta-submenu-item {{ request()->routeIs('wallet-transactions.*') ? 'active' : '' }}">Transactions</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Payment Cards -->
                <li>
                    <a href="{{ route('payment-cards.index') }}" class="ta-menu-item {{ request()->routeIs('payment-cards.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>Payment Cards</span>
                    </a>
                </li>

                <!-- Rewards -->
                <li>
                    <a href="{{ route('rewards.index') }}" class="ta-menu-item {{ request()->routeIs('rewards.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        <span>Rewards</span>
                    </a>
                </li>
            </ul>

            <!-- ========== CONTENT ========== -->
            <h2 class="ta-menu-title">Content</h2>
            @php
                $contentRoutes = [
                    'splash-screens.*', 'select-city-pages.*', 'phone-number-pages.*', 'otp-pages.*',
                    'home-page-contents.*', 'new-order-pages.*', 'order-customization-pages.*',
                    'cart-page-contents.*', 'checkout-page-contents.*', 'add-address-pages.*',
                    'access-location-pages.*', 'profile-pages.*', 'card-details-pages.*',
                    'successful-pages.*', 'drawer-pages.*', 'wallet-pages.*',
                    'change-information-pages.*', 'personal-information-pages.*',
                    'signup-pages.*', 'signin-pages.*', 'forgot-password-pages.*',
                    'account-tier-pages.*', 'redeem-rewards-pages.*'
                ];
            @endphp
            <ul class="ta-menu">
                <li>
                    <button class="ta-menu-item {{ request()->routeIs($contentRoutes) ? 'active' : '' }}"
                        data-bs-toggle="collapse" data-bs-target="#contentMenu" aria-expanded="{{ request()->routeIs($contentRoutes) ? 'true' : 'false' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span>Dynamic Pages</span>
                        <span class="ta-menu-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </button>
                    <div class="collapse {{ request()->routeIs($contentRoutes) ? 'show' : '' }}" id="contentMenu">
                        <ul class="ta-submenu">
                            <!-- Onboarding -->
                            <li class="ta-submenu-group">Onboarding</li>
                            <li><a href="{{ route('splash-screens.index') }}" class="ta-submenu-item {{ request()->routeIs('splash-screens.*') ? 'active' : '' }}">Splash Screen</a></li>
                            <li><a href="{{ route('select-city-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('select-city-pages.*') ? 'active' : '' }}">Select City</a></li>

                            <!-- Authentication -->
                            <li class="ta-submenu-group">Authentication</li>
                            <li><a href="{{ route('phone-number-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('phone-number-pages.*') ? 'active' : '' }}">Phone Number</a></li>
                            <li><a href="{{ route('otp-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('otp-pages.*') ? 'active' : '' }}">OTP</a></li>
                            <li><a href="{{ route('signup-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('signup-pages.*') ? 'active' : '' }}">Signup</a></li>
                            <li><a href="{{ route('signin-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('signin-pages.*') ? 'active' : '' }}">Signin</a></li>
                            <li><a href="{{ route('forgot-password-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('forgot-password-pages.*') ? 'active' : '' }}">Forgot Password</a></li>

                            <!-- Main Pages -->
                            <li class="ta-submenu-group">Main Pages</li>
                            <li><a href="{{ route('home-page-contents.index') }}" class="ta-submenu-item {{ request()->routeIs('home-page-contents.*') ? 'active' : '' }}">Home</a></li>
                            <li><a href="{{ route('profile-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('profile-pages.*') ? 'active' : '' }}">Profile</a></li>
                            <li><a href="{{ route('drawer-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('drawer-pages.*') ? 'active' : '' }}">Drawer</a></li>

                            <!-- Order Flow -->
                            <li class="ta-submenu-group">Order Flow</li>
                            <li><a href="{{ route('new-order-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('new-order-pages.*') ? 'active' : '' }}">New Order</a></li>
                            <li><a href="{{ route('order-customization-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('order-customization-pages.*') ? 'active' : '' }}">Order Customization</a></li>
                            <li><a href="{{ route('cart-page-contents.index') }}" class="ta-submenu-item {{ request()->routeIs('cart-page-contents.*') ? 'active' : '' }}">Cart</a></li>
                            <li><a href="{{ route('checkout-page-contents.index') }}" class="ta-submenu-item {{ request()->routeIs('checkout-page-contents.*') ? 'active' : '' }}">Checkout</a></li>
                            <li><a href="{{ route('successful-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('successful-pages.*') ? 'active' : '' }}">Success</a></li>

                            <!-- Address & Location -->
                            <li class="ta-submenu-group">Address & Location</li>
                            <li><a href="{{ route('add-address-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('add-address-pages.*') ? 'active' : '' }}">Add Address</a></li>
                            <li><a href="{{ route('access-location-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('access-location-pages.*') ? 'active' : '' }}">Access Location</a></li>

                            <!-- Payment & Wallet -->
                            <li class="ta-submenu-group">Payment & Wallet</li>
                            <li><a href="{{ route('card-details-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('card-details-pages.*') ? 'active' : '' }}">Card Details</a></li>
                            <li><a href="{{ route('wallet-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('wallet-pages.*') ? 'active' : '' }}">Wallet</a></li>
                            <li><a href="{{ route('account-tier-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('account-tier-pages.*') ? 'active' : '' }}">Account Tier</a></li>
                            <li><a href="{{ route('redeem-rewards-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('redeem-rewards-pages.*') ? 'active' : '' }}">Redeem Rewards</a></li>

                            <!-- User Info -->
                            <li class="ta-submenu-group">User Info</li>
                            <li><a href="{{ route('personal-information-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('personal-information-pages.*') ? 'active' : '' }}">Personal Info</a></li>
                            <li><a href="{{ route('change-information-pages.index') }}" class="ta-submenu-item {{ request()->routeIs('change-information-pages.*') ? 'active' : '' }}">Change Info</a></li>
                        </ul>
                    </div>
                </li>
            </ul>

            <!-- ========== SETTINGS ========== -->
            <h2 class="ta-menu-title">Settings</h2>
            <ul class="ta-menu">
                <li>
                    <a href="{{ route('profile') }}" class="ta-menu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>My Profile</span>
                    </a>
                </li>

                @can('admin')
                    @php $userMgmtRoutes = ['user-management.*', 'role-management.*']; @endphp
                    <li>
                        <button class="ta-menu-item {{ request()->routeIs($userMgmtRoutes) ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#userMgmtMenu" aria-expanded="{{ request()->routeIs($userMgmtRoutes) ? 'true' : 'false' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>User Management</span>
                            <span class="ta-menu-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </span>
                        </button>
                        <div class="collapse {{ request()->routeIs($userMgmtRoutes) ? 'show' : '' }}" id="userMgmtMenu">
                            <ul class="ta-submenu">
                                <li><a href="{{ route('user-management.index') }}" class="ta-submenu-item {{ request()->routeIs('user-management.*') ? 'active' : '' }}">Users List</a></li>
                                <li><a href="{{ route('role-management.index') }}" class="ta-submenu-item {{ request()->routeIs('role-management.*') ? 'active' : '' }}">Roles</a></li>
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
