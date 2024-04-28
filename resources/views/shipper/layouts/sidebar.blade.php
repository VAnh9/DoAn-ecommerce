<div class="dashboard_sidebar">
    <span class="close_icon">
      <i class="far fa-bars dash_bar"></i>
      <i class="far fa-times dash_close"></i>
    </span>
    <a href="{{ url('/') }}" class="dash_logo"><img src="{{ asset( $logoSettings->logo ) }}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link" style="margin-top: 18px">
      <li><a class="{{ setActive(['shipper.dashboard']) }}" href="{{ route('shipper.dashboard') }}"><i class="fas fa-tachometer"></i>Dashboard</a></li>
      <li><a class="{{ setActive(['shipper.orders.*']) }}" href="{{ route('shipper.orders.index') }}"><i class="fas fa-list-ul"></i> Orders</a></li>
      <li><a class="{{ setActive(['shipper.messages.*']) }}" href="{{ route('shipper.messages.index') }}"><i class="far fa-comment"></i> Message</a></li>
      <li><a class="{{ setActive(['shipper.profile.*']) }}" href="{{ route('shipper.profile') }}"><i class="far fa-user"></i> My Profile</a></li>
      <li>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            this.closest('form').submit();"><i class="far fa-sign-out-alt"></i> Log out</a>
        </form>
      </li>

    </ul>
</div>
