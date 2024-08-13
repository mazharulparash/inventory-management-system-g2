<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">IMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('report-sales.index', 'report-sales.download', 'report-product-sales.index', 'report-product-sales.download') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link {{ request()->routeIs('report-sales.index', 'report-product-sales.index') ? 'active' : '' }}">
                      <i class="nav-icon fas fa-chart-pie"></i>
                      <p>
                          Reports
                          <i class="right fas fa-angle-left"></i>
                      </p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('report-sales.index') }}" class="nav-link {{ request()->routeIs('report-sales.index', 'report-sales.download') ? 'active' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Sales</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('report-product-sales.index') }}" class="nav-link {{ request()->routeIs('report-product-sales.index', 'report-product-sales.download') ? 'active' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Sales by Product</p>
                          </a>
                      </li>
                  </ul>
              </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>