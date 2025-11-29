<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="topnav-dashboard" role="button" >
                            <i class="ri-check-double-line me-1"></i> 
                                Select All
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="topnav-dashboard" role="button" >
                            <i class="ri-pages-line me-1"></i> 
                                Shipping Notes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="topnav-dashboard" role="button" >
                            <i class="ri-archive-line me-1"></i> 
                                Packing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="topnav-dashboard" role="button" >
                            <i class="ri-file-pdf-line me-1"></i> 
                                TearSheet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="topnav-dashboard" role="button" >
                            <i class="ri-upload-line me-1"></i> 
                                Export Photos
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link " href="{{ route('pdf1')}}" target="_blank" id="topnav-dashboard" role="button" >
                            <i class="ri-printer-line me-1"></i> 
                                Box Label
                        </a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-printer-line me-1"></i> 
                            Box Label 
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                            <a href="{{ route('pdf1')}}" target="_blank" class="dropdown-item">PDF1</a>
                            <a href="{{ route('pdf2')}}" target="_blank" class="dropdown-item">PDF2</a>
                            <a href="{{ route('pdf3')}}" target="_blank" class="dropdown-item">PDF3</a>
                            <a href="{{ route('pdf4')}}" target="_blank" class="dropdown-item">PDF4</a>
                            <a href="{{ route('pdf5')}}" target="_blank" class="dropdown-item">PDF5</a>
                            <a href="{{ route('pdf6')}}" target="_blank" class="dropdown-item">PDF6</a>
                        </div>
                    </li>
                </ul> <!-- end navbar-->
            </div> <!-- end .collapsed-->
        </nav>
    </div> <!-- end container-fluid -->
</div>