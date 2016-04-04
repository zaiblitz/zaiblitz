
<div id="main-wrapper">

    <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
        <!-- Main menu toggle -->
        <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
        
        <div class="navbar-inner">
            <!-- Main navbar header -->
            <div class="navbar-header">

                <!-- Logo -->
                <a href="index.html" class="navbar-brand">
                    <div><img alt="Pixel Admin" src="http://infinite-woodland-5276.herokuapp.com/assets/images/pixel-admin/main-navbar-logo.png"></div>
                    PixelAdmin
                </a>

                <!-- Main navbar toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
            </div>

            <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
                <div>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">First item</a></li>
                                <li><a href="#">Second item</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Third item</a></li>
                            </ul>
                        </li>
                    </ul> <!-- / .navbar-nav -->

                    <div class="right clearfix">
                        <ul class="nav navbar-nav pull-right right-navbar-nav">

                            <li>
                                <form class="navbar-form pull-left">
                                    <input type="text" class="form-control" placeholder="Search">
                                </form>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                    <img src="<?php echo base_url();?>media/images/zairus.jpg">
                                    <span>Merwin Dale</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><span class="label label-warning pull-right">New</span>Profile</a></li>
                                    <li><a href="#"><span class="badge badge-primary pull-right">New</span>Account</a></li>
                                    <li><a href="#"><i class="dropdown-icon fa fa-cog"></i>&nbsp;&nbsp;Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="pages-signin.html"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
                                </ul>
                            </li>
                        </ul> 
                    </div>
                </div>
            </div> 
        </div>
    </div> 

    <div id="main-menu" role="navigation">
        <div id="main-menu-inner">
            <div class="menu-content top" id="menu-content-demo">
                <div>
                    <div class="text-bg"><span class="text-slim">Welcome,</span> <span class="text-semibold">Zai</span></div>

                    <img src="<?php echo base_url();?>media/images/zairus.jpg" alt="" class="">
                    <div class="btn-group">
                        <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a>
                        <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
                        <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
                        <a href="#" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
                    </div>
                    <a href="#" class="close">&times;</a>
                </div>
            </div>
            <ul class="navigation">
                <li>
                    <a href="index.html"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">Dashboard</span></a>
                </li>
                
                <li class="mm-dropdown">
                    <a href="index.html"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">Datatables</span></a>  
                    <ul>
                         <li>
                            <a tabindex="-1" href="<?php  echo base_url();?>datatables"><span class="mm-text">List</span></a>
                        </li>
                    </ul>
                </li>

                <li class="mm-dropdown">
                    <a href="#"><i class="menu-icon fa fa-desktop"></i><span class="mm-text">Bootstrap</span></a>
                    <ul>
                        <li>
                            <a tabindex="-1" href="ui-buttons.html"><span class="mm-text">Buttons</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="ui-typography.html"><span class="mm-text">Typography</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="ui-tabs.html"><span class="mm-text">Tabs &amp; Accordions</span></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="ui-modals.html"><span class="mm-text">Modals</span></a>
                        </li>
                    </ul>
                </li>
            <div class="menu-content">
                <a href="#" class="btn btn-primary btn-block btn-outline dark" id="btnLogout">Logout</a>
            </div>
        </div> 
    </div> 

