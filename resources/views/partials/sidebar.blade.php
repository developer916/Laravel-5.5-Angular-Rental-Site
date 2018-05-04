<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="start active ">
                <a href="{{URL::to('/')}}">
                    <i class="fa fa-cogs"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{URL::to('/admin/properties/')}}">
                    <i class="icon-home"></i>
                    <span class="title">Properties</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{URL::to('/admin/property/create')}}">
                            <i class="icon-home"></i>
                            Add New Property</a>
                    </li>
                    <li>
                        <a href="{{URL::to('/admin/properties')}}">
                            <i class="icon-basket"></i>
                            All Properties</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-users"></i>
                    <span class="title">Tenants</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{URL::to('/admin/tenant/create')}}">
                            <i class="icon-home"></i>
                            Add New Tenant</a>
                    </li>
                    <li>
                        <a href="{{URL::to('/admin/tenants')}}">
                            <i class="icon-basket"></i>
                            All Tenants</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{URL::to('/admin/tenants')}}">
                    <i class="icon-refresh"></i>
                    <span class="title">Activity</span>
                </a>
            </li>
            <li>
                <a href="{{URL::to('/admin/payments')}}">
                    <i class="fa fa-money"></i>
                    <span class="title">Payments</span>
                </a>
            </li>
            <li>
                <a href="{{URL::to('/admin/invoices')}}">
                    <i class="fa fa-university"></i>
                    <span class="title">Invoices</span>
                </a>
            </li>
            <li>
                <a href="{{URL::to('/admin/reports')}}">
                    <i class="fa fa-bar-chart"></i>
                    <span class="title">Reports</span>
                </a>
            </li>
            <li>
                <a href="{{URL::to('/admin/settings')}}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>