<!DOCTYPE html>
<html lang="en" data-topbar-color="brand" data-sidebar-size="condensed">
    <head>
        <meta charset="utf-8" />
        <title> @yield('title') </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="App for selling and managing the collection and delivery of the product" name="description" />
        <meta content="Dataloggers" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
        @include('layouts.head-css')
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">
            
            <!-- Topbar Start -->
            @include( 'layouts.topbar-v' )
            <!-- Topbar End -->

            <!-- ========== Left Sidebar Start ========== -->
            @include( 'layouts.sidebar')
            <!-- Left Sidebar End -->
      
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        @yield('content')    

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                @include('layouts.footer')
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        @include('layouts.right-sidebar')
        <!-- END Right Sidebar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        @include('layouts.vendor-scripts')
        
    </body>
</html>