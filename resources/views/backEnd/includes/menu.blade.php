<body class="pr-0">
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
                        <a href="{{route('admin.dashboard')}}">                            
                            {{ $system->application_name ?? str_replace('_',' ', env('APP_NAME')) }}
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        
                        <ul class="nav-right"> 
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">                                        
                                        <img src="{{ file_exists(Auth::guard('admin')->user()->image)? asset(Auth::guard('admin')->user()->image):asset('image/dummy_user.jpg') }}" class="img-radius" alt="Image">
                                        <span>{{Auth::guard('admin')->user()->name}}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="{{ route('admin.edit',['id' => Auth::guard('admin')->user()->id])}}" class="ajax-click-page" ><i class="feather icon-user"></i> Profile</a>
                                        </li>                                        
                                        <li>
                                            <a href="{{ route('admin.logout') }} "><i class="feather icon-log-out"></i> Logout</a>
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
                                    <a href="{{ route('admin.dashboard') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                <li class="{{ isset($nav) && $nav == 'activity_log' ? 'pcoded-trigger active-menu' : null }}">
                                    <a href="{{ route('admin.activity_log') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Activity Log</span>
                                    </a>
                                </li>
                                

                                <?php
                                    $accesses = ['advisor_list', 'advisor_create', 'advisor_update', 'advisor_billing', "advisor_update",'advisor_delete','advisor_deleted_list', "import_advisor_list"];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Advisor List -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'advisor' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                            <span class="pcoded-mtext" >Advisor List</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess(['advisor_create','advisor_update']))
                                                <li class="{{ isset($subNav) && $subNav == "advisor.create" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('advisor.create')}}"><i class="fas fa-user-plus"></i> Add Advisor</a>
                                                </li>
                                            @endif
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess('advisor_list'))
                                                <li class="{{ isset($subNav) && $subNav == "advisor.list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('advisor.list')}}"><i class="fas fa-align-justify"></i> View Advisors</a>
                                                </li>
                                            @endif 
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess('advisor_missing_info_list'))
                                                <li class="{{ isset($subNav) && $subNav == "advisor.missing_info_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('advisor.missing_info_list')}}"><i class="fas fa-align-justify"></i> New Advisors List</a>
                                                </li>
                                            @endif 
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess(['import_advisor_list']))
                                                <li class="{{ isset($subNav) && $subNav == "advisor.import" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('advisor.import')}}"><i class="fa fa-upload"></i> Import Advisors</a>
                                                </li>
                                            @endif 
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess(['advisor_billing', 'advisor_update']))
                                                <li class="{{ isset($subNav) && $subNav == "advisor.billing_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('advisor.billing_list')}}"><i class="far fa-address-card"></i> Advisor Billing</a>
                                                </li>
                                            @endif
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess(['promotional_list', 'promotional_create']))
                                                <li class="{{ isset($subNav) && $subNav == "advisor.promotional_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('advisor.promotional_list')}}"><i class="far fa-address-card"></i> Promotional List</a>
                                                </li>
                                            @endif 
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess(['advisor_deleted_list']))
                                                <li class="{{ isset($subNav) && $subNav == "advisor.archived_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('advisor.archived_list')}}"><i class="fas fa-trash-restore-alt"></i> Deleted Advisors</a>
                                                </li>
                                            @endif
                                                                 
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['office_manager_list', 'office_manager_create', 'office_manager_update', 'office_manager_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- office_manager -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'office_manager' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-users-cog"></i></span>
                                            <span class="pcoded-mtext" >Office Manager</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "create" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('office_manager.create')}}"><i class="fas fa-plus-square"></i> Add Office Manager </a>
                                            </li>                              
                                            <li class="{{ isset($subNav) && $subNav == "list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('office_manager.list')}}"><i class="fas fa-list-alt"></i> All Office Manager</a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "archive_list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('office_manager.archived_list')}}"><i class="fas fa-list-alt"></i> Deleted Office Managers</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif


                                <?php
                                    $accesses = ['lead_list', 'lead_create', 'lead_update', 'lead_delete', "lead_archive_list"];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Lead-->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'lead' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-running"></i></span>
                                            <span class="pcoded-mtext" >Manage Leads</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "lead.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('lead.list')}}"><i class="fas fa-list-alt"></i> All Leads</a>
                                            </li> 
                                            <li class="{{ isset($subNav) && $subNav == "lead.search_locally" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('lead.search_locally')}}"><i class="fas fa-search-location"></i> Search Local </a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "lead.match_me" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('lead.match_me')}}"><i class="far fa-handshake"></i> Match Me </a>
                                            </li>
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("lead_archive_list"))
                                                <li class="{{ isset($subNav) && $subNav == "lead.archive_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('lead.archive_list')}}"><i class="fas fa-trash-restore-alt"></i> Deleted Leads </a>
                                                </li>  
                                            @endif                                   
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['auction_list', "auction_create", 'auction_update', 'auction_delete', "auction_restore", "auction_archive_list"];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- auction-->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'auction' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-gavel"></i></span>
                                            <span class="pcoded-mtext" >Manage Auctions</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "auction.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('auction.list')}}"><i class="fas fa-list-alt"></i> All Auctions</a>
                                            </li> 
                                            <li class="{{ isset($subNav) && $subNav == "auction.search_locally" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('auction.search_locally')}}"><i class="fas fa-search-location"></i> Search Local </a>
                                            </li>
                                            <li class="{{ isset($subNav) && $subNav == "auction.match_me" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('auction.match_me')}}"><i class="far fa-handshake"></i> Match Me </a>
                                            </li> 
                                            <li class="{{ isset($subNav) && $subNav == "auction.accept_list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('auction.accept_list')}}"><i class="fas fa-list-alt"></i> Accept Terms and Condition</a>
                                            </li>
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("auction_archive_list"))
                                                <li class="{{ isset($subNav) && $subNav == "auction.archive_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('auction.archive_list')}}"><i class="fas fa-list-alt"></i> Deleted Auctions</a>
                                                </li>
                                            @endif                                     
                                        </ul>
                                    </li>
                                @endif

                                <!-- Match Rating -->
                                <?php
                                    $accesses = ['match_rating_list', "match_rating_create", 'match_rating_update', 'match_rating_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- match_rating-->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'match_rating' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-star-half-alt"></i></span>
                                            <span class="pcoded-mtext" >Manage Match Ratings</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "match_rating.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('match_rating.list')}}"><i class="fas fa-list-alt"></i> Match Ratings List</a>
                                            </li>                                      
                                        </ul>
                                    </li>
                                @endif

                                <!-- Advisor Question -->
                                <?php
                                    $accesses = ['advisorQuestion_list', 'advisorQuestion_create', 'advisorQuestion_update', 'advisorQuestion_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'advisorQuestion' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="far fa-question-circle"></i></span>
                                            <span class="pcoded-mtext" >Advisor Case Studies</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "advisorQuestion.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisorQuestion.list')}}"><i class="fas fa-list-alt"></i> Advisor Case Studies List </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                <!-- Advisor Interview Question -->
                                <?php
                                    $accesses = ['interview_question_list', 'interview_question_create', 'interview_question_update', 'interview_question_delete', 'interview_question_answer_list'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'interview_question' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-running"></i></span>
                                            <span class="pcoded-mtext" >Advisor Interview</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                                <li class="{{ isset($subNav) && $subNav == "interview_question.list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('interview_question.list')}}"><i class="fas fa-list-alt"></i> Questions List </a>
                                                </li>     
                                            @endif    
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess('interview_question_answer_list'))
                                                <li class="{{ isset($subNav) && $subNav == "interview_question.answer_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('interview_question.answer_list')}}"><i class="fas fa-list-alt"></i> Answers List </a>
                                                </li> 
                                            @endif
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['advisorType_list', 'advisorType_create', 'advisorType_update', 'advisorType_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Advisor Type -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'advisorType' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fab fa-app-store-ios"></i></span>
                                            <span class="pcoded-mtext" >Advisor Type</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "advisorType.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisorType.list')}}"><i class="fas fa-list-alt"></i> Advisor Type List</a>
                                            </li>                             
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['profession_list', 'profession_create', 'profession_update', 'profession_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Profession -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'profession' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-running"></i></span>
                                            <span class="pcoded-mtext" >Profession</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "profession.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('profession.list')}}"><i class="fas fa-list-alt"></i> Profession List </a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif
                                
                                <?php
                                    $accesses = ['firmSize_list', 'firmSize_create', 'firmSize_update', 'firmSize_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Firm Size -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'firmSize' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-landmark"></i></span>
                                            <span class="pcoded-mtext" >Firm Size</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "firmSize.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('firmSize.list')}}"><i class="fas fa-list-alt"></i> Firm Size List</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['fundSize_list', 'fundSize_create', 'fundSize_update', 'fundSize_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Fund Size -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'fundSize' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="far fa-money-bill-alt"></i></span>
                                            <span class="pcoded-mtext" >Fund Size List</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "fundSize.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('fundSize.list')}}"><i class="fas fa-list-alt"></i> Fund Size List</a>
                                            </li>                              
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['serviceOffer_list', 'serviceOffer_create', 'serviceOffer_update', 'serviceOffer_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Service Offer -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'serviceOffer' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"> <i class="fas fa-snowflake"></i> </span>
                                            <span class="pcoded-mtext" >Areas of Advice</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "serviceOffer.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('serviceOffer.list')}}"> <i class="fas fa-list-alt"></i> Areas of Advice List</a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['primaryReason_list', 'primaryReason_create', 'primaryReason_update', 'primaryReason_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Primary Region -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'primaryReason' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-landmark"></i></span>
                                            <span class="pcoded-mtext" >Primary Region</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "primaryReason.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('primaryReason.list')}}"><i class="fas fa-list-alt"></i> Primary Region List</a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                               

                                <?php
                                    $accesses = ['postcode_list', "postcode_deleted_list",'postcode_create', 'postcode_update', 'postcode_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Primary Region -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'postcode' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-map-marked-alt"></i></span>
                                            <span class="pcoded-mtext" >Primary Postcodes</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess(['postcode_list', 'postcode_create', 'postcode_update', 'postcode_delete']))
                                                <li class="{{ isset($subNav) && $subNav == "postcode.list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('postcode.list')}}"><i class="fas fa-list-alt"></i> Primary Postcodes List</a>
                                                </li>
                                            @endif  
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("postcode_deleted_list"))
                                                <li class="{{ isset($subNav) && $subNav == "postcode.deleted_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('postcode.deleted_list')}}"><i class="fas fa-trash"></i> Deleted Primary Postcodes </a>
                                                </li>
                                            @endif                               
                                        </ul>
                                    </li>
                                @endif
                                
                                 <!--  Primary Subscription Locations -->
                                <?php
                                    $accesses = ['subscribePrimaryReason_list', 'subscribePrimaryReason_create', 'subscribePrimaryReason_update', 'subscribePrimaryReason_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'subscribePrimaryReason' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-landmark"></i></span>
                                            <span class="pcoded-mtext" > Subscription Regions</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "subscribePrimaryReason.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('subscribePrimaryReason.list')}}"><i class="fas fa-list-alt"></i> Subscription Regions List</a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['subscribePostcode_list', 'subscribePostcode_create', 'subscribePostcode_update', 'subscribePostcode_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Primary Region -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'subscribePostcode' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-map-marked-alt"></i></span>
                                            <span class="pcoded-mtext" >Subscription Postcodes</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "subscribePostcode.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('subscribePostcode.list')}}"><i class="fas fa-list-alt"></i> Subscription Postcodes List</a>
                                            </li>                               
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['subscription_list', 'subscription_create', 'subscription_update', 'subscription_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Subscription -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'subscription' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fab fa-buffer"></i></span>
                                            <span class="pcoded-mtext" >Subscription Plans</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "subscription.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('subscription.list')}}"><i class="fas fa-list-alt"></i> Plan List </a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif
                                
                                <?php
                                    $accesses = ['testimonial_list', 'testimonial_create', 'testimonial_update', 'testimonial_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Testimonial -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'testimonial' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-medal"></i></span>
                                            <span class="pcoded-mtext" >Advisor Testimonials</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "testimonial.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('testimonial.list')}}"><i class="fas fa-list-alt"></i> Testimonials List </a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['communication_list', 'communication_create', 'communication_update', 'communication_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Communication -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'communication' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-blender-phone"></i></span>
                                            <span class="pcoded-mtext" >Advisor Communications  </span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "communication.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('communication.list')}}"><i class="fas fa-list-alt"></i> Advisor Communications List </a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['blog_list', 'blog_create', 'blog_update', 'blog_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- blog -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'blog' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-book"></i></span>
                                            <span class="pcoded-mtext" >Blogs </span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "blog.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('blog.list')}}"><i class="fas fa-list-alt"></i> Blog Posts List  </a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['advisor_blog_list', 'advisor_blog_create', 'advisor_blog_update', 'advisor_blog_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- blog -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'advisor_blog' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-book"></i></span>
                                            <span class="pcoded-mtext" >Advisor Blogs </span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "advisor_blog.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor_blog.list')}}"><i class="fas fa-list-alt"></i>Advisor Blog Posts List  </a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['tips_guides_list', 'tips_guides_create', 'tips_guides_update', 'tips_guides_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- blog -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'tips_guides' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-book"></i></span>
                                            <span class="pcoded-mtext" > Tips & Guides </span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "tips_guides.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('tips_guides.list')}}"><i class="fas fa-list-alt"></i> Tips & Guides List </a>
                                            </li>                                     
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['enquires'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- enquires -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'enquires' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="{{ route('enquires.list') }}">
                                            <span class="pcoded-micon"><i class="fab fa-staylinked"></i></span>
                                            <span class="pcoded-mtext" > Enquires / Contact Table</span>
                                        </a>                                        
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['terms_&_condition_list', 'terms_&_condition_create', 'terms_&_condition_update', 'terms_&_condition_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- terms_&_condition_list -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'terms_&_condition' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="jabascript::;">
                                            <span class="pcoded-micon"><i class="fab fa-staylinked"></i></span>
                                            <span class="pcoded-mtext" > Dynamic Page Content</span>
                                        </a> 
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "terms_&_condition.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('terms_&_condition.list') }}"><i class="fas fa-list-alt"></i>Dynamic Page Content List</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['quick_link_list', 'quick_link_create', 'quick_link_edit', 'quick_link_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Quick Link -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'quick_link' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fab fa-staylinked"></i></span>
                                            <span class="pcoded-mtext" >Quick Links</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "quick_link.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('quick_link.list')}}"><i class="fas fa-list-alt"></i> Quick Link List </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                <?php
                                    $accesses = ['advisor_quick_link_list', 'advisor_quick_link_create', 'advisor_quick_link_edit', 'advisor_quick_link_delete'];
                                ?>
                                <!-- Advisor Quick Link -->
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))                                    
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'advisor_quick_link' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fab fa-staylinked"></i></span>
                                            <span class="pcoded-mtext" >Advisor Quick Links</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "advisor_quick_link.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('advisor_quick_link.list')}}"><i class="fas fa-list-alt"></i>Advisor Quick Link List </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                <!-- FAQ -->
                                <?php
                                    $accesses = ['faq_list', 'faq_create', 'faq_edit', 'faq_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))                                    
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'faq' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fab fa-staylinked"></i></span>
                                            <span class="pcoded-mtext" >FAQ</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "faq.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('faq.list')}}"><i class="fas fa-list-alt"></i> FAQ List </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                <!-- Social Media -->
                                <?php
                                    $accesses = ['social_media_list', 'social_media_create', 'social_media_edit', 'social_media_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))                                    
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'social_media' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fab fa-staylinked"></i></span>
                                            <span class="pcoded-mtext" >Social Media</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "social_media.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('social_media.list')}}"><i class="fas fa-list-alt"></i> Social Media List </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                <!-- Page -->
                                <?php
                                    $accesses = ['page_list', 'page_create', 'page_edit', 'page_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))                                    
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'page' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fab fa-staylinked"></i></span>
                                            <span class="pcoded-mtext" >Pages</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "page.list" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('page.list')}}"><i class="fas fa-list-alt"></i> Page List </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                                


                                <?php
                                    $accesses = ['admin_list', 'admin_create', 'admin_delete', 'admin_restore'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Admin Section -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'admin' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fa fa-user"></i></span>
                                            <span class="pcoded-mtext" >Admin</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("admin_list"))
                                                <li class="{{ isset($subNav) && $subNav == "admin.list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('admin.list') }}"><i class="fas fa-user-cog"></i> Admin List</a>
                                                </li>
                                            @endif
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("admin_restore"))
                                                <li class="{{ isset($subNav) && $subNav == "admin.archive_list" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('admin.archive_list') }}"><i class="fas fa-user-plus"></i> Archived Admin</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>                               
                                @endif

                                <?php
                                    $accesses = [ 'email_send', "email_option", "email_template", 'email_configuration'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Email Send -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'email' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-cogs"></i></span>
                                            <span class="pcoded-mtext" >Email Settings</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("email_send"))
                                                <li class="{{ isset($subNav) && $subNav == "send" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('email.send') }}"><i class="fas fa-envelope-open-text"></i> Send Email </a>
                                                </li>
                                            @endif


                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("email_template"))
                                                <li class="{{ isset($subNav) && $subNav == "template" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('email.template') }}"><i class="fas fa-envelope"></i> Email Template</a>
                                                </li>
                                            @endif

                                            @if(App\Http\Controllers\BackEnd\AccessController::checkAccess("email_configuration"))
                                                <li class="{{ isset($subNav) && $subNav == "configuration" ? 'active-subMenu' : 'none' }}" >
                                                    <a href="{{ route('email.configuration') }}"><i class="far fa-envelope"></i> Email Configuration</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                     
                                @endif

                                <?php
                                    $accesses = ['fetchfy_configuration_list', "fetchfy_configuration_create", "fetchfy_configuration_update", "fetchfy_configuration_delete"];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Email Send -->
                                    <li class="pcoded-hasmenu {{ isset($nav) && $nav == 'fetchfy_configuration' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i class="fas fa-cogs"></i></span>
                                            <span class="pcoded-mtext" >Fetchfy Configuration</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="{{ isset($subNav) && $subNav == "send" ? 'active-subMenu' : 'none' }}" >
                                                <a href="{{ route('fetchfy_configuration.list') }}"><i class="fas fa-envelope-open-text"></i> Fetchfy Configuration List </a>
                                            </li>
                                        </ul>
                                    </li>
                                     
                                @endif
                                
                                <?php
                                    $accesses = ['setting'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Groups -->
                                    <li class="{{ isset($nav) && $nav == 'website.settings' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="{{ route('admin.website.setting')}}">
                                            <span class="pcoded-micon"><i class="fas fa-cogs"></i></span>
                                            <span class="pcoded-mtext" >Website Settings</span>
                                        </a>
                                    </li>   
                                @endif

                                <?php
                                    $accesses = ['group_list', 'group_create', 'group_update', 'group_delete'];
                                ?>
                                @if(App\Http\Controllers\BackEnd\AccessController::checkAccess($accesses))
                                    <!-- Groups -->
                                    <li class="{{ isset($nav) && $nav == 'group' ? 'pcoded-trigger active-menu' : null }}">
                                        <a href="{{ route('group.list')}}">
                                            <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                            <span class="pcoded-mtext" >Group Permissions</span>
                                        </a>
                                    </li>   
                                @endif 

                            </ul>                            
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">
                                    