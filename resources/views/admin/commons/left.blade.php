<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">MAIN NAVIGATION</li>
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'Orders')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-bars"></i> <span>Orders</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.orders') }}"><i class="fa fa-list text-blue"></i> {{ __('admin.Lists') }}</a></li>
                </ul>
            </li>

            {{-- <li class="{{ (strpos(request()->route()->getActionName(), 'Category')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-bars"></i> <span>Category</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.categorys.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.categorys.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'OperatingCompanyMaster')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-bars"></i> <span>Operating company</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.operating_company.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.operating_company.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'RegionMaster')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-bars"></i> <span>Region</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.region.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.region.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'StationNameMaster')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-bars"></i> <span>Station name</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.station.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.station.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'FloorPlanMaster')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-bars"></i> <span>Floor plan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.floor_plan.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.floor_plan.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>

             <li class="{{ (strpos(request()->route()->getActionName(), 'CityMaster')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-bars"></i> <span>City</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.city.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.city.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'Messages')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Messages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.messages.index') }}"><i class="fa fa-list text-blue"></i> List from users</a></li>
                    <li><a href="{{ route('admin.yourContact') }}"><i class="fa fa-list text-green"></i> Your Contact</a></li>
                    <li><a href="{{ route('admin.yourMessage') }}"><i class="fa fa-list text-green"></i> Your Messages</a></li>
                </ul>
            </li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'Users')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.users.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
{{--                    <li><a href="{{ route('admin.users.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>--}}
                {{-- </ul> --}}
            </li>


            <li class="header">SETTINGS</li>
            {{-- <li class="{{ (strpos(request()->route()->getActionName(), 'Locations')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-location-arrow"></i> <span>Locations</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.locations.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.locations.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>



            <li class="{{ (strpos(request()->route()->getActionName(), 'Languages')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-language"></i> <span>Languages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.languages.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.languages.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li>

            <li class="{{ (strpos(request()->route()->getActionName(), 'Currencies')) ? 'active' : ''}} treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Currencies</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.currencies.index') }}"><i class="fa fa-list text-blue"></i> Lists</a></li>
                    <li><a href="{{ route('admin.currencies.create') }}"><i class="fa fa-plus text-yellow"></i> New</a></li>
                </ul>
            </li> --}}
{{--            <li><a href="#"><i class="fa fa-cogs text-red"></i> <span>System settings</span></a></li>--}}

            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Account</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route("admin.profile") }}"><i class="fa fa-circle-o"></i> Profiles</a></li>
                    <li><a  href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
