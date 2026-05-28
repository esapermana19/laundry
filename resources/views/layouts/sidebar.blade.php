        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="index.html" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                fill="#0081C9" />
                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                fill="#0081C9" />
                        </svg>
                    </span>
                    <span class="app-brand-text demo menu-text fw-bold">Jacusa</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                    <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboards -->
                <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-home"></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->is(['services', 'customers',]) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-database"></i>
                        <div>Data Master</div>
                        <div class="badge bg-label-primary rounded-pill ms-auto"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->is('services') ? 'active' : '' }}">
                            <a href="{{ route('services.index') }}" class="menu-link">
                                <div>Layanan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('customers') ? 'active' : '' }}">
                            <a href="{{ route('customers.index') }}" class="menu-link">
                                <div>Pelanggan</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text text-cyan-600">Transaksi</span>
                </li>
                <li class="menu-item {{ request()->is('transactions/create') ? 'active' : '' }}">
                    <a href="{{ route('transactions.create') }}" class="menu-link">
                        <i class="menu-icon ti ti-sort-descending-2"></i>
                        <div>Pesanan Baru</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('transactions') ? 'active' : '' }}">
                    <a href="{{ route('transactions.index') }}" class="menu-link">
                        <i class="menu-icon ti ti-list"></i>
                        <div>Daftar Pesanan</div>
                    </a>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text text-cyan-600">Laporan</span>
                </li>
                <li class="menu-item {{ request()->is('transactions/report*') ? 'active' : '' }}">
                    <a href="{{ route('transactions.report') }}" class="menu-link">
                        <i class="menu-icon ti ti-report-analytics"></i>
                        <div>Laporan</div>
                    </a>
                </li>
                {{-- <li
                    class="menu-item {{ request()->is(['products', 'customers', 'suppliers', 'categories']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-sort-ascending"></i>
                        <div>Pesanan</div>
                        <div class="badge bg-label-primary rounded-pill ms-auto">4</div>
                    </a>
                    <ul class="menu-sub">


                    </ul>
                </li> --}}
                {{-- <li class="menu-item {{ request()->is('sales', 'sales/*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <i class="menu-icon ti ti-shopping-cart"></i>
                        <div>Sales Transaction</div>
                    </a>
                </li> --}}

                <!-- Layouts -->

                {{-- <li class="menu-item">
                    <a href="app-email.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-mail"></i>
                        <div data-i18n="Email">Email</div>
                    </a>
                </li> --}}
            </ul>
        </aside>
