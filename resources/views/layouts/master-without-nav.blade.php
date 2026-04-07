<!doctype html>
<html lang="en" data-topbar-color="brand" data-sidebar-size="condensed">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="App for selling and managing the collection and delivery of the product" name="description" />
    <meta content="Dataloggers" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('layouts.head-css')
</head>

    @yield('content')

    @include('layouts.vendor-scripts')
    </body>
</html>
