<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->getAvatar() }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->getFullname() }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Manage Products</p>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('department.index') }}" class="nav-link {{ activeSegment('department') }}">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Departments</p>
                        </a>
                        <a href="{{ route('products.index') }}" class="nav-link {{ activeSegment('products') }}">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Products</p>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Manage Locations</p>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('location.index') }}" class="nav-link {{ activeSegment('location') }}">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Locations</p>
                        </a>
                        <a href="{{ route('location.index') }}" class="nav-link {{ activeSegment('location') }}">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Location Tables</p>
                        </a>
                    </div>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('unit.index') }}" class="nav-link {{ activeSegment('units') }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Units</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('printer_group.index') }}" class="nav-link {{ activeSegment('printer_group') }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Printer Groups</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('cart.index') }}" class="nav-link {{ activeSegment('cart') }}">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Open POS</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('orders.index') }}" class="nav-link {{ activeSegment('orders') }}">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('customers.index') }}" class="nav-link {{ activeSegment('customers') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ activeSegment('settings') }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                        <form action="{{route('logout')}}" method="POST" id="logout-form">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>