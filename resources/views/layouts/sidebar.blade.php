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

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{route('products.index')}}">
                        <i class="mdi mdi-24px mdi-tag-outline"></i>
                        <span>Products</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('discounts.index')}}">
                        <i class="mdi mdi-24px mdi-currency-usd"></i>
                        <span>Discounts</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="mdi mdi-24px mdi-clipboard-list-outline"></i>
                        <span>Sales Order Flow</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="mdi mdi-24px mdi-package-variant-closed"></i>
                        <span>Shipping Labels</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('warehouses.index')}}">
                        <i class="mdi mdi-24px mdi-warehouse"></i>
                        <span>Warehouse Portal</span>
                    </a>
                </li>

                <li>
                    <a href="#sideCustomers" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sideCustomers">
                        <i class="mdi mdi-24px mdi-account-outline"></i>
                        <span> Customers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sideCustomers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('customers.index')}}">List</a>
                            </li>
                            <li>
                                <a href="{{route('customerCategory.index')}}">Categories</a>
                            </li>
                            <li>
                                <a href="{{route('customerSettings.index')}}">
                                    <span>Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">Maintainers</li>


                <li>
                    <a href="#sideMaintainer" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="sideMaintainer">
                        <i class="mdi mdi-24px mdi-list-status"></i>
                        <span> Maintainers List </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sideMaintainer">
                        <ul class="nav-second-level">

                            <li>
                                <a href="{{route('attributes.show')}}">Features</a>
                            </li>                            
                            <li>
                                <a href="{{route('categories.index')}}">Categories</a>
                            </li>
                            <li>
                                <a href="{{route('status.show')}}">Status</a>
                            </li>
                            <li>
                                <a href="{{route('origin.show')}}">Origin</a>
                            </li>
                            <li>
                                <a href="{{route('brands.show')}}">Brands</a>
                            </li>
                            <li>
                                <a href="{{route('ProductsType.show')}}">Products Types</a>
                            </li>
                            <li>
                                <a href="{{route('measures.show')}}">Measures</a>
                            </li>
                            <li>
                                <a href="{{route('productsParts.show')}}">Products Parts</a>
                            </li>
                            <li>
                                <a href="{{route('productsMaterials.show')}}">Products Materials</a>
                            </li>
                            <li>
                                <a href="{{route('packages-type.show')}}">Package Type</a>
                            </li>
                            <li>
                                <a href="{{route('ship-via.show')}}">Ship Via</a>
                            </li>
                            <li>
                                <a href="{{route('casepack.show')}}">Case Pack</a>
                            </li>
                            <li>
                                <a href="{{route('boxContent.show')}}">Box Content</a>
                            </li>
                            <li>
                                <a href="{{route('pallets.show')}}">Pallets</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">System</li>
                <li>
                    <a href="{{route('userSettings.index')}}">
                        <i class="mdi mdi-24px mdi-cogs"></i>
                        <span>User Settings</span>
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