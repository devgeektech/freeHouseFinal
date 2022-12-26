 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15"> </div>
        <div class="sidebar-brand-text mx-6">Free House Design</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.dashboard') }}"> <i class="fas fa-fw fa-tachometer-alt"></i> 
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/plans*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.plans.index') }}"> <i class="fas fa-fw fa-list"></i> 
            <span>Plans</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/customers*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.customers.index') }}"> <i class="fas fa-fw fa-list"></i> 
            <span>Customers</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/custom_designs*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.custom_designs.index') }}"> <i class="fas fa-fw fa-list"></i> 
            <span>Custom Designs</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/advertisements*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.advertisements.index') }}"> <i class="fas fa-fw fa-list"></i> <span>Advertisements</span></a>
    </li>
</ul>
<!-- End of Sidebar -->