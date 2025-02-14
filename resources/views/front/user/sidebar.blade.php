<nav class="sidebar sidebar-offcanvas" id="sidebar">

  <ul class="nav">

  <li class="nav-item {{ Request::is('customerDashboard') ? 'active' : '' }}">

      <a class="nav-link" href="{{url('customerDashboard')}}" >

      <i class="fa fa-th" aria-hidden="true"></i>

          <span class="menu-title">Dashboard</span>

        <i class="menu-arrow"></i>

      </a>

    </li><li class="nav-item {{ Request::is('customerProfile') ? 'active' : '' }}">

      <a class="nav-link" href="{{url('customerProfile')}}">

        <i class="fa fa-user"></i>

          <span class="menu-title">My Profile</span>

        <i class="menu-arrow"></i>

      </a>

    </li>

    <li class="nav-item ">

      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">

        <i class="fa fa-shopping-cart"></i>

          <span class="menu-title">Subscription plan</span>

        <i class="menu-arrow"></i>

      </a>

    </li>

    <li class="nav-item {{ Request::is('customerMessages') ? 'active' : '' }}">

      <a class="nav-link" href="{{url('customerMessages')}}">

        <i class="fa fa-comment"></i>

          <span class="menu-title">Message</span>

        <i class="menu-arrow"></i>

      </a>

    </li>

 
    <li class="nav-item {{ Request::is('chatRoom') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('chatRoom')}}">
        <i class="fa fa-video"></i>
          <span class="menu-title">Video Chat</span>
        <i class="menu-arrow"></i>
      </a>
    </li>
 

  </ul>

</nav>