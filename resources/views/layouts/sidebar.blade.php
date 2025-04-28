  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-teal elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard') }}" class="brand-link tw-text-lg">
          <img src="{{ asset('image/logo.png') }}" alt="{{ config('app.name') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <li class="nav-item">
                      <a href="{{ route('dashboard') }}" class="nav-link @yield('dashboard-page-active')">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('user.index') }}" class="nav-link @yield('user-page-active')">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                              User
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('wallet.index') }}" class="nav-link @yield('wallet-page-active')">
                          <i class="nav-icon fas fa-wallet"></i>
                          <p>
                              Wallet
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('ticket-inspector.index') }}" class="nav-link @yield('ticket-inspector-page-active')">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                              Ticket Inspector
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('admin-user.index') }}" class="nav-link @yield('admin-user-page-active')">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                              Admin User
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
