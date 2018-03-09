<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $currentUser->image or '/images/user/default_user.jpg' }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $currentUser->name }}</p>
                <!-- Status -->
                <a href="{{ route('user.profile') }}"><i class="fa  fa-hand-o-right"></i> View Profile</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN MENU</li>
            <li class="{{ Request::is('dashboard')? 'active' : '' }}">
                <a href="{{ route('user.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if($currentUser->isAdmin() || $currentUser->isUser())
                <li class="treeview {{ Request::is('reports/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-briefcase"></i>
                        <span>Reports</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('reports/account-statement')? 'active' : '' }}">
                            <a href="{{ route('report.account-statement') }}">
                                <i class="fa fa-circle-o text-green"></i> Account Statement
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ (Request::is('transportations/*') || Request::is('transportations')) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-road"></i>
                        <span>Transportations</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('transportations/create')? 'active' : '' }}">
                            <a href="{{ route('transportations.create') }}">
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('transportations')? 'active' : '' }}">
                            <a href="{{ route('transportations.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ ( Request::is('supply/*') || Request::is('supply') )? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-refresh"></i>
                        <span>Material Supply</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('supply/create')? 'active' : '' }}">
                            <a href="{{ route('supply.create') }}">
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('supply')? 'active' : '' }}">
                            <a href="{{ route('supply.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('expenses/*') || Request::is('expenses')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-wrench"></i>
                        <span>Services & Expences</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('expenses/create')? 'active' : '' }}">
                            <a href="{{route('expenses.create') }}">
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('expenses')? 'active' : '' }}">
                            <a href="{{ route('expenses.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('vouchers/*') || Request::is('vouchers')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-envelope-o"></i>
                        <span>Vouchers & Reciepts</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('vouchers/create')? 'active' : '' }}">
                            <a href="{{route('vouchers.create') }}">
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('vouchers')? 'active' : '' }}">
                            <a href="{{route('vouchers.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('accounts/*') || Request::is('accounts') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>Accounts</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('accounts/create')? 'active' : '' }}">
                            <a href="{{route('accounts.create') }}">
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('accounts')? 'active' : '' }}">
                            <a href="{{route('accounts.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('sites/*') || Request::is('sites')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-map-marker"></i>
                        <span>Sites</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('sites/create')? 'active' : '' }}">
                            <a href="{{route('sites.create') }}">
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('sites')? 'active' : '' }}">
                            <a href="{{route('sites.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('trucks/*') || Request::is('trucks') ? 'active' : '' }}">
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
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('trucks')? 'active' : '' }}">
                            <a href="{{route('trucks.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('employees/*') || Request::is('employees')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-male"></i>
                        <span>Employees</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('employees/create')? 'active' : '' }}">
                            <a href="{{route('employees.create') }}">
                                <i class="fa fa-circle-o text-yellow"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('employees')? 'active' : '' }}">
                            <a href="{{route('employees.index') }}">
                                <i class="fa fa-circle-o text-aqua"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>