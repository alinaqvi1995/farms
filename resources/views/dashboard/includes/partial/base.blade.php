<!doctype html>
<html lang="en" data-bs-theme="semi-dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Farm Management</title>
    <link rel="icon" href="{{ asset('admin/images/favicon-32x32.png') }}" type="image/png">

    <!-- inject:css -->
    <link href="{{ asset('admin/css/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('admin/js/pace.min.js') }}"></script>

    {{-- Datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!--plugins-->
    <link href="{{ asset('admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/fullcalendar/css/main.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/metismenu/metisMenu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/metismenu/mm-vertical.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/simplebar/css/simplebar.css') }}">

    <!--bootstrap css-->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">

    {{-- select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    {{-- summernote --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!--main css-->
    <link href="{{ asset('admin/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/sass/main.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/sass/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/sass/blue-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/sass/semi-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/sass/bordered-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/sass/responsive.css') }}" rel="stylesheet">

    @yield('extra_css')
</head>

<body>
    <style>
        .suggestions-box {
            position: relative;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            z-index: 9999;
            display: none;
        }

        .suggestions-box div {
            padding: 8px 12px;
            cursor: pointer;
        }

        .suggestions-box div:hover {
            background: #f0f0f0;
        }

        .make-select,
        .model-select {
            width: 100%;
        }

        select option {
            white-space: nowrap;
        }
    </style>

    @section('navbar')
        @include('dashboard.includes.partial.nav')
    @show

    @section('sidebar')
        @include('dashboard.includes.partial.sidebar')
    @show

    <!--================= Wrapper Start Here =================-->
    <main class="main-wrapper">
        <div class="main-content">
            {{-- Success message --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Generic error message --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->

    @section('footer')
        @include('dashboard.includes.partial.footer')
    @show

    @section('cart')
        @include('dashboard.includes.partial.cart')
    @show

    @section('switcher')
        @include('dashboard.includes.partial.switcher')
    @show

    <!--end main wrapper-->

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/plugins/metismenu/metisMenu.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap bundle -->
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>

    {{-- summernote --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    @yield('extra_js')

    @if (Route::currentRouteName() !== 'reports.quotes.histories')
        <script>
            // Initialize DataTable
            let table = $('.datatable').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });

            // modal
            if ($.fn.modal) {
                // Patch enforceFocus only if Constructor exists (Bootstrap 4.x)
                if ($.fn.modal.Constructor) {
                    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
                }
            }

            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                allowClear: true,
            });

            // summernote
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        </script>
    @endif

    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate">
    </script>

    <style>
        .goog-te-banner-frame.skiptranslate,
        .goog-te-gadget-icon,
        .goog-te-gadget-simple,
        .goog-tooltip,
        .goog-te-balloon-frame {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .goog-text-highlight {
            background-color: transparent !important;
            box-shadow: none !important;
        }
    </style>
    <script>
        function loadGoogleTranslate() {
            new google.translate.TranslateElement({
                pageLanguage: "en",
                includedLanguages: 'ur,en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, "google_element");
        }

        function setLanguage(lang) {
            // Clear existing cookies
            var host = window.location.hostname;
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + host;
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + host;

            if (lang !== 'en') {
                var targetCookie = "/en/" + lang;
                document.cookie = "googtrans=" + targetCookie + "; path=/;";
                document.cookie = "googtrans=" + targetCookie + "; path=/; domain=" +
                host; // Try setting on domain too to be safe
            }

            // Reload with cache busting to force hard refresh behavior
            var url = new URL(window.location.href);
            url.searchParams.set('lang_t', new Date().getTime());
            window.location.href = url.toString();
        }

        // Aggressively hide Google Translate Banner
        document.addEventListener("DOMContentLoaded", function() {
            function removeGoogleBanner() {
                // 1. Find and hide specific frames
                var bannerFrames = document.querySelectorAll(".goog-te-banner-frame, iframe.skiptranslate");
                bannerFrames.forEach(function(frame) {
                    frame.style.display = "none";
                    frame.style.visibility = "hidden";
                    frame.style.height = "0";
                });

                // 2. Hide specific classes often associated with the top banner
                var bannerDivs = document.querySelectorAll(".skiptranslate.goog-te-gadget-simple");
                bannerDivs.forEach(function(div) {
                    // Verify it's not our language switcher by checking location or content if needed
                    // But usually the top banner has this class at the body level
                    if (div.parentNode === document.body) {
                        div.style.display = "none";
                    }
                });

                // 3. Generic check for the top spacer iframe generated by Google
                var topFrame = document.querySelector('iframe[id=":2.container"]');
                if (topFrame) {
                    topFrame.style.display = 'none';
                    topFrame.style.visibility = 'hidden';
                }

                // 4. Force body to top 0
                if (document.body.style.top !== "0px") {
                    document.body.style.top = "0px";
                    document.body.style.position = ""; // Remove relative/static if google adds it badly
                }
            }

            // Run immediately and then on interval
            removeGoogleBanner();
            setInterval(removeGoogleBanner, 100);
        });
    </script>

    <script src="{{ asset('admin/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/js/main.js') }}"></script>
</body>

</html>
