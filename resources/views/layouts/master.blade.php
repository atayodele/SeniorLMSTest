<!DOCTYPE html>
<html>
    <head>
        @include('layouts/header')
        @toastr_css        
    </head>
    <body class="page-header-fixed compact-menu page-horizontal-bar">
        <div class="overlay"></div>
        <main class="page-content content-wrap">
            @include('layouts/navbar')
            <div class="page-inner">
                @yield('breadcrumb')
                <div id="main-wrapper" class="container">
					@yield('content')
                </div><!-- Main Wrapper -->
                @include('layouts/footer')
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
        <div class="cd-overlay"></div>
	        <!-- Javascripts -->
        @jquery
        @toastr_js
        @toastr_render
        @include('layouts/script')
    </body>
</html>
