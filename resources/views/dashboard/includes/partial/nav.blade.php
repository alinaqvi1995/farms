<!--================= Header Section Start Here =================-->
<!--start header-->
<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
        <div class="btn-toggle">
            <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
        </div>
        <div class="search-bar flex-grow-1">
            <div class="position-relative">
                <input class="form-control rounded-5 px-5 search-control d-lg-block d-none" type="text"
                    placeholder="Search">
                <span
                    class="material-icons-outlined position-absolute d-lg-block d-none ms-3 translate-middle-y start-0 top-50">search</span>
                <span
                    class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close">close</span>
                <div class="search-popup p-3">
                    <div class="card rounded-4 overflow-hidden">
                        <div class="card-header d-lg-none">
                            <div class="position-relative">
                                <input class="form-control rounded-5 px-5 mobile-search-control" type="text"
                                    placeholder="Search">
                                <span
                                    class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                                <span
                                    class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 mobile-search-close">close</span>
                            </div>
                        </div>
                        <div class="card-body search-content">
                            <p class="search-title">Quick Links</p>
                            <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                                <a href="{{ route('dashboard') }}" class="kewords">
                                    <span>Dashboard</span>
                                    <i class="material-icons-outlined fs-6">dashboard</i>
                                </a>

                                @can('view-categories')
                                    <a href="{{ route('categories.index') }}" class="kewords">
                                        <span>Categories ({{ $categoriesCount ?? 0 }})</span>
                                        <i class="material-icons-outlined fs-6">category</i>
                                    </a>
                                @endcan

                                @can('view-subcategories')
                                    <a href="{{ route('subcategories.index') }}" class="kewords">
                                        <span>Subcategories ({{ $subcategoriesCount ?? 0 }})</span>
                                        <i class="material-icons-outlined fs-6">subtitles</i>
                                    </a>
                                @endcan

                                @can('view-blogs')
                                    <a href="{{ route('blogs.index') }}" class="kewords">
                                        <span>Blogs ({{ $blogsCount ?? 0 }})</span>
                                        <i class="material-icons-outlined fs-6">article</i>
                                    </a>
                                    <a href="{{ route('blogs.create') }}" class="kewords">
                                        <span>Create Blog</span>
                                        <i class="material-icons-outlined fs-6">post_add</i>
                                    </a>
                                @endcan

                                @can('view-users')
                                    <a href="{{ route('dashboard.users.index') }}" class="kewords">
                                        <span>Users ({{ $usersCount ?? 0 }})</span>
                                        <i class="material-icons-outlined fs-6">people</i>
                                    </a>
                                @endcan

                                @can('view-roles')
                                    <a href="{{ route('roles.index') }}" class="kewords">
                                        <span>Roles</span>
                                        <i class="material-icons-outlined fs-6">admin_panel_settings</i>
                                    </a>
                                @endcan
                            </div>

                        </div>

                        <div class="card-footer text-center bg-transparent">
                            <a href="javascript:;" class="btn w-100">See All Search Results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="navbar-nav gap-1 nav-right-links align-items-center">
            <li class="nav-item d-lg-none mobile-search-btn">
                <a class="nav-link" href="javascript:;"><i class="material-icons-outlined">search</i></a>
            </li>
            <li class="nav-item dropdown notranslate">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                    data-bs-toggle="dropdown">
                    <i class="material-icons-outlined">language</i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0);"
                            onclick="setLanguage('en')">
                            <span class="ms-2">English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0);"
                            onclick="setLanguage('ur')">
                            <span class="ms-2">Urdu</span>
                        </a>
                    </li>
                    <li style="display:none;">
                        <div id="google_element"></div>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown notranslate">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                    data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i
                        class="material-icons-outlined">notifications</i>
                    {{-- <span class="badge-notify">{{ $recentActivities->count() }}</span> --}}
                </a>
                <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
                    <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
                        <h5 class="notiy-title mb-0">Notifications</h5>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-icons-outlined">
                                    more_vert
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                                <div>
                                    <a href="{{ route('view.activity_logs') }}"
                                        class="dropdown-item d-flex align-items-center gap-2 py-2">
                                        <i class="material-icons-outlined fs-6">list</i> View All Logs
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notify-list" style="max-height: 300px; height: auto; overflow-y: auto;">
                        @foreach ($recentActivities as $activity)
                            <div>
                                <a class="dropdown-item border-bottom py-2" href="javascript:;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="">
                                            {{-- Removing image as requested --}}
                                        </div>
                                        <div class="">
                                            <h5 class="notify-title">{{ $activity->readable_causer }}</h5>
                                            <p class="mb-0 notify-desc">{{ $activity->description }}
                                                #{{ $activity->subject_id }}</p>
                                            <p class="mb-0 notify-time">{{ $activity->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        @if ($recentActivities->isEmpty())
                            <div class="text-center p-3 text-muted">No recent activity.</div>
                        @endif

                        <div class="text-center p-2">
                            <a href="{{ route('view.activity_logs') }}" class="btn btn-link link-primary p-0">View
                                All</a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="javascript:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->detail && auth()->user()->detail->profile_image
                        ? asset(auth()->user()->detail->profile_image)
                        : 'https://placehold.co/110x110/png' }}"
                        class="rounded-circle p-1 border" width="45" height="45" alt="User Avatar">
                </a>

                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow p-3 rounded-4"
                    style="min-width: 250px;">
                    <!-- User Header -->
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ auth()->user()->detail && auth()->user()->detail->profile_image
                            ? asset(auth()->user()->detail->profile_image)
                            : 'https://placehold.co/110x110/png' }}"
                            class="rounded-circle me-2 border" width="55" height="55" alt="User Avatar">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ auth()->user()->name }}</h6>
                            <small
                                class="text-muted">{{ auth()->user()->roles->pluck('name')->first() ?? 'User' }}</small>
                            <br>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                    </div>

                    <hr class="dropdown-divider">

                    <!-- Optional: Farm Info (if farm admin) -->
                    @if (auth()->user()->hasRole('farm_admin') && auth()->user()->farm)
                        <div class="mb-2">
                            <small class="text-muted">Farm:</small>
                            <p class="mb-0 fw-semibold">{{ auth()->user()->farm->name }}</p>
                        </div>
                        <hr class="dropdown-divider">
                    @endif

                    <!-- Links -->
                    @can('edit-profile')
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('profile.edit') }}">
                            <i class="material-icons-outlined">person_outline</i>
                            Profile
                        </a>
                    @endcan

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2">
                            <i class="material-icons-outlined">power_settings_new</i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>

    </nav>
</header>
<!--end top header-->
<!--================= Header Section End Here =================-->
