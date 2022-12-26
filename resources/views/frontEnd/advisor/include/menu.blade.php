<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header" style="background:#404E67;color:#fff;">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="{{route('advisor.dashboard')}}">    
                            <img src="{{ asset(isset($system->logo) && file_exists($system->logo) ? $system->logo : 'image/logo-white.png' ) }}" alt="{{ $system->application_name ?? str_replace('_',' ', env('APP_NAME')) }}" height="60">   
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn text-white"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()" data-cf-modified-0825fa4f27dc602956ba7c8c-="">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right"> 
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">                                        
                                        <!--<img src="{{ file_exists(Auth::user()->image)? asset(Auth::user()->image):asset('image/dummy_user.jpg') }}" class="img-radius" alt="{{ Auth::user()->first_name ?? "Image" }}">
                                        <span>{{ Auth::user()->first_name ?? "" }}</span>-->
                                        @if(Auth::user()->subscription_plan_id == 9)
                                        <span>{{ Auth::user()->first_name ?? "" }}</span>
                                        @else
                                        <img src="{{ file_exists(Auth::user()->image)? asset(Auth::user()->image):asset('image/dummy_user.jpg') }}" class="img-radius" alt="{{ Auth::user()->first_name ?? "Image" }}">
                                        <span>{{ Auth::user()->first_name ?? "" }}</span>
                                        @endif
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="{{ route('advisor.profile_self') }}" ><i class="feather icon-user"></i> Profile</a>
                                        </li>                                        
                                        <li>
                                            <a href="{{ route('advisor.logout') }} "><i class="feather icon-log-out"></i> Logout</a>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Top Navigation End -->
            
            <!-- Left Sidebar start -->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">{{ isset($system) ? $system->applicationName : Null}}</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <!-- Dashboard -->
                                <li class="{{ isset($nav) && $nav == 'dashboard' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="{{ route('advisor.dashboard') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                
                                <?php
                                    $auth_user = Auth::user("office_manager");
                                    $office_manager = $auth_user->subscription_plan->office_manager ?? false;
                                ?>
                                @if($auth_user->getTable() == "advisors" && $office_manager &&  empty($auth_user->office_manager_id) )
                                    
                                    <!-- Advisor List -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'advisor' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                            <span class="pcoded-mtext" >Build Office Manager</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            
                                            <li class="{{ isset($subNav) && $subNav == "advisor.create" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('office_manager.advisor.create')}}"><i class="fas fa-user-plus"></i> Add Advisor</a>
                                            </li>

                                            <!--<li class="{{ isset($subNav) && $subNav == "advisor.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('office_manager.advisor.list')}}"><i class="fas fa-align-justify"></i> View Advisors</a>
                                            </li>-->

                                            <!--<li class="{{ isset($subNav) && $subNav == "advisor.archived_list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('office_manager.advisor.archived_list')}}"><i class="fas fa-trash-restore-alt"></i> Deleted Advisors</a>
                                            </li>-->
                                            
                                            <li class="{{ isset($subNav) && $subNav == "advisor.billing_info" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('office_manager.advisor.billing_info')}}"><i class="far fa-address-card"></i> Billing Info</a>
                                            </li>                    
                                        </ul>
                                    </li>
                                @else
                                    <!-- Advisor List -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'advisor' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                            <span class="pcoded-mtext" >Build Your Profile</span>
                                        </a>
                                        <ul class="pcoded-submenu">                                        
                                            <li class="{{ isset($subNav) && $subNav == "advisor.profile_self" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.profile_self') }}" target="_blank"><i class="fas fa-align-justify"></i> My Profile</a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "advisor.profile_update" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.profile_update') }}"><i class="fas fa-edit"></i> Update Profile</a>
                                            </li> 
                                            <li class="{{ isset($subNav) && $subNav == "advisor.password_change" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.password_change') }}"><i class="fas fa-edit"></i> Change Password</a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "advisor.firm" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.firm') }}"><i class="fas fa-home"></i> Firm Info</a>
                                            </li> 
                                            <li class="{{ isset($subNav) && $subNav == "advisor.billing_info" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.billing_info') }}"><i class="fas fa-money-bill-wave"></i> Billing Info</a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "advisor.compliance" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.compliance.list') }}"><i class="fas fa-edit"></i>Compliance Statement</a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "advisor.interview" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.interview.list') }}"><i class="fas fa-edit"></i>Interview</a>
                                            </li>                         
                                        </ul>
                                    </li>

                                   <!-- Quistion -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'question' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="far fa-question-circle"></i></span>
                                            <span class="pcoded-mtext" >Case Studies</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "question.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.question.list')}}"> <i class="fas fa-align-justify"></i> Case Studies List </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Testimonial -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'testimonial' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="far fa-check-circle"></i></span>
                                            <span class="pcoded-mtext" >Testimonials</span>
                                        </a>
                                        <ul class="pcoded-submenu">                                        
                                            <li class="{{ isset($subNav) && $subNav == "testimonial.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.testimonial.list')}}"> <i class="fas fa-align-justify"></i> Testimonials List</a>
                                            </li>                          
                                        </ul>
                                    </li>

                                    <!-- Leads -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'leads' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-skiing-nordic"></i></span>
                                            <span class="pcoded-mtext" >Manage Leads</span>
                                        </a>
                                        <ul class="pcoded-submenu">                                        
                                            <li class="{{ isset($subNav) && $subNav == "leads.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.leads.list')}}"> <i class="fas fa-align-justify"></i> Lead List</a>
                                            </li>                          
                                        </ul>
                                    </li>

                                    <!-- Auction -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'auction' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-gavel"></i></span>
                                            <span class="pcoded-mtext" >Manage Auction</span>
                                        </a>
                                        <ul class="pcoded-submenu">                                        
                                            <li class="{{ isset($subNav) && $subNav == "auction.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.auction.list')}}"> <i class="fas fa-align-justify"></i> Auction List</a>
                                            </li>                          
                                        </ul>
                                    </li>

                                    <!-- Communication -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'communication' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="far fa-comments"></i></span>
                                            <span class="pcoded-mtext" >Communications</span>
                                        </a>
                                        <ul class="pcoded-submenu">                                        
                                            <li class="{{ isset($subNav) && $subNav == "communication.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor.communication.list')}}"> <i class="fas fa-align-justify"></i>Communications List</a>
                                            </li>                          
                                        </ul>
                                    </li>
                                    <!-- Match Rating -->
                                    <li class="{{ isset($nav) && $nav == 'match_rating' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="{{ route('advisor.match_rating') }}">
                                            <span class="pcoded-micon"><i class="far fa-grin-stars"></i></span>
                                            <span class="pcoded-mtext" >Match Rating</span>
                                        </a>                                    
                                    </li>
                                    <!-- Marketing Bedge -->
                                    <li class="{{ isset($nav) && $nav == 'marketing_profile' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="{{ route('advisor.marketing_profile') }}">
                                            <span class="pcoded-micon"><i class="fas fa-download"></i></span>
                                            <span class="pcoded-mtext" >Marketing Badges</span>
                                        </a>                                    
                                    </li>
                                @endif

                                <!-- Logout -->
                                <li class="active-menu">
                                    <a href="{{ route('advisor.logout') }} " class="text-danger"><i class="fas fa-power-off"></i> Logout</a>
                                </li>

                            </ul>                            
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">