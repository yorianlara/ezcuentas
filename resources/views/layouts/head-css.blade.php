<!-- App css -->
<link href="{{URL::asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('/assets/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-stylesheet" />

<!-- icons -->
<link href="{{URL::asset('/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Theme Config Js -->
<script src="{{URL::asset('/assets/js/config.js')}}"></script>

<!-- Boostrap Table -->
<link href="{{URL::asset('/assets/libs/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Select 2 -->
<link href="{{URL::asset('/assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('/assets/libs/select2/css/select2-bootstrap-5-theme.min.css')}}" rel="stylesheet" type="text/css" />

<!-- switchery -->
<link href="{{URL::asset('/assets/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />


<link href="{{URL::asset('assets/libs/hopscotch/css/hopscotch.min.css')}}" rel="stylesheet" type="text/css" />

<!-- toastr -->
<link href="{{URL::asset('/assets/libs/toastr/build/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<!-- sweetalert2 -->
<link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<style>
    /* Reset de estilos que podrían estar siendo afectados por hopscotch */
    #toast-container {
        position: fixed;
        z-index: 999999 !important; /* Asegura que esté por encima de hopscotch */
    }
    #toast-container > div {
        opacity: 1 !important;
        background-color: #030303 !important;
        color: white !important;
        padding: 15px 15px 15px 50px !important;
        box-shadow: 0 0 12px #000 !important;
        width: 300px !important;
    }
    #toast-container > .toast-success {
        background-color: #51A351 !important;
    }
    #toast-container > .toast-error {
        background-color: #BD362F !important;
    }
    #toast-container > .toast-info {
        background-color: #2F96B4 !important;
    }
    #toast-container > .toast-warning {
        background-color: #F89406 !important;
    }
</style>
@yield('css')