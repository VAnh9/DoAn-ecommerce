<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
    </form>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{ asset(Auth::user()->image)}}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-title">Logged in 5 min ago</div>
          <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profile
          </a>
          <a href="{{ route('admin.settings.index') }}" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Settings
          </a>
          <div class="dropdown-divider"></div>

          <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
            @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
        </div>
      </li>
    </ul>
  </nav>
