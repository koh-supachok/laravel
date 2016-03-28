<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ asset(env('ASSET_PATH').'/img/profile_small.jpg') }}" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{$user->firstname.' '.$user->lastname}}</strong>
                             </span> <span class="text-muted text-xs block">{{$user->user_group}} <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">{{$menu}}</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li>
                    <a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">Dashboards</span> <span class="label label-primary pull-right">NEW</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-lightbulb-o"></i> <span class="nav-label">{{$menu}}</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">สแกนแบบสั่งงาน<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="en_scan">ผลการแสกนประจำวัน</a>
                                </li>
                                <li>
                                    <a href="en_scan_graph">สรุปผลการแสกน</a>
                                </li>
                                <li>
                                    <a href="en_scan_search">ค้นหา</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>