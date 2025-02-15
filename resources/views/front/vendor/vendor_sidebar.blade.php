<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ Request::is('vendorsDasboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('vendorsDasboard')}}">
        <i class="fa fa-th" aria-hidden="true"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('ProfileSetting') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('ProfileSetting')}}" >
        <i class="fa fa-user"></i>
        <span class="menu-title">My Profile</span> <i class="menu-arrow"></i>
      </a>
    </li>

    <li class="nav-item {{ Request::is('updateSubject') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('updateSubject')}}" >
        <i class="fa fa-book"></i>
        <span class="menu-title">My Subjects</span> <i class="menu-arrow"></i>
      </a>
    </li>

    <li class="nav-item {{ Request::is('vendor-wallet') ? 'active' : '' }}"">
      <a class="nav-link"  href="{{url('vendor-wallet')}}" >
        <i class="fas fa-wallet"></i>
        <span class="menu-title">Guruer Wallet</span> <i class="menu-arrow"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#" aria-expanded="false" aria-controls="form-elements">
        <i class="fa fa-shopping-cart"></i>
        <span class="menu-title">Orders</span> <i class="menu-arrow"></i>
      </a>
    </li>

    <li class="nav-item {{ Request::is('vendorMessages') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('vendorMessages')}}">
        <i class="fa fa-comment"></i>
          <span class="menu-title">Message</span> <i class="menu-arrow"></i>
      </a>
    </li>

    <li class="nav-item {{ Request::is('chatRoom') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('chatRoomVendor')}}">
        <i class="fa fa-video"></i>
          <span class="menu-title">Video Chat</span>
        <i class="menu-arrow"></i>
      </a>
    </li>
  </ul>
</nav>