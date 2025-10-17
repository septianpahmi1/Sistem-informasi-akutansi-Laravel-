<aside class="main-sidebar bg-white elevation-2">
    <a href="index3.html" class="brand-link">
        <img src="dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle " style="opacity: .8">
        <span class="brand-text font-weight-bold"><strong>SIA</strong>kuntansi</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">USER MANAGEMENT</li>
                <li class="nav-item menu-open">
                    <a href="{{ route('users') }}" class="nav-link {{ Request::is('users') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Pengguna
                        </p>
                    </a>
                </li>
                <li class="nav-header">MASTER DATA</li>
                <li class="nav-item menu-open">
                    <a href="{{ route('account') }}" class="nav-link {{ Request::is('account') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Akun
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('supplier') }}" class="nav-link {{ Request::is('supplier') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Supplier
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('customer') }}" class="nav-link{{ Request::is('customer') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Customer
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('mitra') }}" class="nav-link{{ Request::is('mitra') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Investor/ Mitra
                        </p>
                    </a>
                </li>
                <li class="nav-header">FAKTUR</li>
                <li class="nav-item menu-open">
                    <a href="{{ route('sales') }}"
                        class="nav-link{{ Request::is(['sales', 'sales/create', 'sales/update/*']) ? ' active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Penjualan
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('purchase') }}"
                        class="nav-link{{ Request::is(['purchase', 'purchase/create', 'purchase/update/*']) ? ' active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Pembelian
                        </p>
                    </a>
                </li>
                <li class="nav-header">JOURNAL</li>
                <li class="nav-item menu-open">
                    <a href="{{ route('journal') }}" class="nav-link{{ Request::is('journal') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Journal
                        </p>
                    </a>

                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('entries') }}"
                        class="nav-link{{ Request::is('journal-entries') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-swatchbook"></i>
                        <p>
                            Daftar Journal
                        </p>
                    </a>

                </li>
                <li class="nav-header">REPORT</li>
                {{-- <li class="nav-item menu-open">
                    <a href="{{ route('reportJournal') }}"
                        class="nav-link{{ Request::is('reports/journal-umum') ? ' active' : '' }}">
                        <i class="fas fa-circle-notch"></i>
                        <p>
                            Journal Umum
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item menu-open">
                    <a href="{{ route('reportLaba') }}"
                        class="nav-link{{ Request::is('reports/laba-rugi') ? ' active' : '' }}">
                        <i class="fas fa-circle-notch"></i>
                        <p>
                            Laba Rugi
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="{{ route('reportAruskas') }}"
                        class="nav-link{{ Request::is('reports/arus-kas') ? ' active' : '' }}">
                        <i class="fas fa-circle-notch"></i>
                        <p>
                            Arus Kas
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
