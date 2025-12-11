<!--start sidebar-->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        {{-- <div class="logo-icon">
            <img src="{{ asset('web-assets/images/logo/logo_001.png') }}" class="logo-img w-100" alt="Logo">
        </div> --}}
        <div class="logo-name flex-grow-1">
            <h6 class="mb-0" style="color: #FC5523 !important">Farm Management</h6>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined notranslate">close</span>
        </div>
    </div>

    <div class="sidebar-nav">
        @php
            $currentStatus = request()->query('status');
        @endphp
        <ul class="metismenu" id="menu">

            <!-- Dashboard -->
            {{-- @can('view-dashboard') --}}
            <li>
                <a href="{{ route('dashboard') }}">
                    <div class="parent-icon notranslate"><i class="material-icons-outlined">dashboard</i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            {{-- @endcan --}}

            <!-- Categories -->
            {{-- @can('view-categories')
                <li class="menu-label">Categories</li>
                <li>
                    <a href="{{ route('categories.index') }}">
                        <div class="parent-icon notranslate"><i class="material-icons-outlined">category</i></div>
                        <div class="menu-title">
                            Categories
                            <span class="badge bg-primary float-end">{{ $categoriesCount ?? 0 }}</span>
                        </div>
                    </a>
                </li>
            @endcan

            @can('view-subcategories')
                <li>
                    <a href="{{ route('subcategories.index') }}">
                        <div class="parent-icon notranslate"><i class="material-icons-outlined">subtitles</i></div>
                        <div class="menu-title">
                            Subcategories
                            <span class="badge bg-primary float-end">{{ $subcategoriesCount ?? 0 }}</span>
                        </div>
                    </a>
                </li>
            @endcan --}}

            @if (auth()->user()->isSuperAdmin())
                <li>
                    <a href="{{ route('farms.index') }}">
                        <div class="parent-icon notranslate"><i class="material-icons-outlined">grass</i></div>
                        <div class="menu-title">
                            Farms
                            <span class="badge bg-primary float-end">{{ $farmsCount ?? 0 }}</span>
                        </div>
                    </a>
                </li>
            @elseif(auth()->user()->isFarmAdmin())
                <li>
                    <a href="{{ route('farms.show', auth()->user()->farm_id) }}">
                        <div class="parent-icon notranslate"><i class="material-icons-outlined">grass</i></div>
                        <div class="menu-title">
                            Farm
                        </div>
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ route('animals.index') }}">
                    <div class="parent-icon notranslate"><i class="material-icons-outlined">pets</i></div>
                    <div class="menu-title">
                        Animals
                        <span class="badge bg-primary float-end">{{ $animalsCount ?? 0 }}</span>
                    </div>
                </a>
                </a>
            </li>

            <li>
                <a href="{{ route('milk_sales.index') }}">
                    <div class="parent-icon notranslate"><i class="material-icons-outlined">water_drop</i></div>
                    <div class="menu-title">
                        Milk Sales
                    </div>
                </a>
            </li>

            <li>
                <a href="{{ route('vendors.index') }}">
                    <div class="parent-icon notranslate"><i class="material-icons-outlined">storefront</i></div>
                    <div class="menu-title">
                        Vendors
                    </div>
                </a>
            </li>

            {{-- <li>
                <a href="{{ route('dashboard.invoice.index') }}">
                    <div class="parent-icon notranslate"><i class="material-icons-outlined">inventory_2</i></div>
                    <div class="menu-title">
                        Invoice
                    </div>
                </a>
            </li> --}}

            <li class="menu-label">Reports</li>
            <li>
                <a href="{{ route('reports.production') }}">
                    <div class="parent-icon notranslate"><i class="material-icons-outlined">analytics</i></div>
                    <div class="menu-title">
                        Milk Production
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('reports.sales') }}">
                    <div class="parent-icon notranslate"><i class="material-icons-outlined">paid</i></div>
                    <div class="menu-title">
                        Milk Sales
                    </div>
                </a>
            </li>

            <!-- Users & Roles -->
            @if (auth()->user()->isSuperAdmin() || auth()->user()->isFarmAdmin())
                <li class="menu-label">Users & Roles</li>
                <li>
                    <a href="{{ route('dashboard.users.index') }}">
                        <div class="parent-icon notranslate"><i class="material-icons-outlined">people</i></div>
                        <div class="menu-title">
                            Users
                            <span class="badge bg-primary float-end">{{ $usersCount ?? 0 }}</span>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('feed_inventories.index') }}" class="nav-link d-flex align-items-center">
                        <div class="parent-icon me-2 notranslate">
                            <i class="material-icons-outlined">grass</i>
                        </div>
                        <span class="menu-title">Feed</span>
                    </a>
                </li>

                @if (auth()->user()->isSuperAdmin())
                    <li>
                        <a href="{{ route('cities.index') }}">
                            <div class="parent-icon notranslate"><i class="material-icons-outlined">location_city</i>
                            </div>
                            <div class="menu-title">Cities</div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('states.index') }}">
                            <div class="parent-icon notranslate"><i class="material-icons-outlined">map</i></div>
                            <div class="menu-title">States</div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('view.activity_logs') }}">
                            <div class="parent-icon notranslate"><i class="material-icons-outlined">people</i></div>
                            <div class="menu-title">Activity Logs</div>
                        </a>
                    </li>

                    <div class="menu-title">Roles</div>
                    </a>
                    </li>

                    <li>
                        <a href="{{ route('settings.index') }}">
                            <div class="parent-icon notranslate"><i class="material-icons-outlined">settings</i></div>
                            <div class="menu-title">Settings</div>
                        </a>
                    </li>
                @endif

                {{-- <li>
                    <a href="{{ route('trusted-ips.index') }}">
                        <div class="parent-icon notranslate"><i class="material-icons-outlined">security</i></div>
                        <div class="menu-title">Trusted IPs</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('reports.quotes.histories') }}">
                        <div class="parent-icon notranslate"><i class="material-icons-outlined">security</i></div>
                        <div class="menu-title">Report</div>
                    </a>
                </li> --}}
            @endif
        </ul>
    </div>
</aside>
<!--end sidebar-->
