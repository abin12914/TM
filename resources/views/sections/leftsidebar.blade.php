<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/user/default_user.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN MENU</li>
            <li class="{{ Request::is('dashboard')? 'active' : '' }}">
                <a href="{{ route('user-dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->isAdmin() || Auth::user()->isUser())
                <li class="treeview {{ Request::is('trucks/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-truck"></i>
                        <span>Trucks</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('trucks/create')? 'active' : '' }}">
                            <a href="{{route('trucks.create') }}">
                                <i class="fa fa-circle-o"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('trucks')? 'active' : '' }}">
                            <a href="{{route('trucks.index') }}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('accounts/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-industry"></i>
                        <span>Accounts</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('accounts/create')? 'active' : '' }}">
                            <a href="{{route('accounts.create') }}">
                                <i class="fa fa-circle-o"></i> Register
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('employees/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-industry"></i>
                        <span>Employees</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('employees/create')? 'active' : '' }}">
                            <a href="{{route('employees.create') }}">
                                <i class="fa fa-circle-o"></i> Register
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('sites/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-industry"></i>
                        <span>Sites</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('sites/create')? 'active' : '' }}">
                            <a href="{{route('sites.create') }}">
                                <i class="fa fa-circle-o"></i> Register
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ (Request::is('transportations/*') || Request::is('supply/*'))? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-industry"></i>
                        <span>Trucking</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview {{ (Request::is('transportations/*') || Request::is('supply/*'))? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-circle-o"></i> Registration
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ Request::is('transportations/create')? 'active' : '' }}">
                                    <a href="{{ route('transportations.create') }}">
                                        <i class="fa fa-circle-o"></i> Transportation
                                    </a>
                                </li>
                                <li class="{{ Request::is('supply/create')? 'active' : '' }}">
                                    <a href="{{ route('supply.create') }}">
                                        <i class="fa fa-circle-o"></i> Supply
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>