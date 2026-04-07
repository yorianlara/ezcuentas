@extends('layouts.master-without-nav')
@section('title')
Login
@endsection

@section('content')
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card">

                    <div class="card-body p-4">
                        
                        <div class="text-center w-75 m-auto">
                            <a href="index.html" class="logo logo-dark text-center">
                                <img src="{{URL::asset('/assets/images/logo-dark.png')}}" alt="" height="22">
                            </a>
                            <p class="text-muted mb-4 mt-3">Ingrese su dirección de correo electrónico y contraseña para acceder al sistema.</p>
                        </div>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-2">
                                <label for="emailaddress" class="form-label">Correo electrónico</label>
                                <input class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="Introduce tu correo electrónico">
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Introduce tu contraseña">
                                    
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">
                                        Remember me
                                    </label>
                                </div>
                            </div> --}}

                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit"> Log In </button>
                            </div>

                        </form>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p> <a href="auth-recoverpw.html" class="text-muted ms-1">Forgot your password?</a></p>
                        
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
@endsection
@section('script')
<script>
    $("[data-password]").on('click', function () {
        if ($(this).prop('data-password') == "false") {
            $(this).siblings("input").prop("type", "text");
            $(this).prop('data-password', 'true');
            $(this).addClass("show-password");
        } else {
            $(this).siblings("input").prop("type", "password");
            $(this).prop('data-password', 'false');
            $(this).removeClass("show-password");
        }
    });
</script>
@endsection