<div class="left-side-menu">

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index.html" class="logo logo-dark text-center">
            <span class="logo-sm">
                <img src="{{URL::asset('/assets/images/logo-sm-dark.png')}}" alt="" height="24">
                <!-- <span class="logo-lg-text-light">Minton</span> -->
            </span>
            <span class="logo-lg">
                <img src="{{URL::asset('/assets/images/logo-dark.png')}}" alt="" height="20">
                <!-- <span class="logo-lg-text-light">M</span> -->
            </span>
        </a>

        <a href="index.html" class="logo logo-light text-center">
            <span class="logo-sm">
                <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt="" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{URL::asset('assets/images/logo-light.png')}}" alt="" height="20">
            </span>
        </a>
    </div>

    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navegacion</li>
                
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="mdi mdi-24px mdi-view-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="menu-title mt-2">Mantenedores</li>


                <li>
                    <a href="{{ route('admin.usuarios.index') }}">
                        <i class="mdi mdi-24px mdi-account-circle"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                
                <li>
                    <a href="#">
                        <i class="mdi mdi-24px mdi-office-building-marker"></i>
                        <span>Empresas</span>
                    </a>
                </li>

                <!--<li>
                    <a href="#sidebarMaps" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMaps">
                        <i class="ri-map-pin-line"></i>
                        <span> Maps </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMaps">
                        <ul class="nav-second-level">
                            <li>
                                <a href="maps-google.html">Google</a>
                            </li>
                            <li>
                                <a href="maps-vector.html">Vector</a>
                            </li>
                            <li>
                                <a href="maps-mapael.html">Mapael</a>
                            </li>
                        </ul>
                    </div>
                </li>-->


            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>