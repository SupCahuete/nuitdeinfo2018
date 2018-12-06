<nav class="nav-wrapper z-depth-2 back-or">
  <a href="@route('TAG_GUARD_NAME.home.index')" class="brand-logo">
    <img id="logo" src="@image('logo.png')" />
  </a>
  <ul id="nav-mobile" class="right">
    <li><a href="@route('TAG_GUARD_NAME.home.index')">@choice('TAG_GUARD_NAME.dashborad', 2)</a></li>
    <li><a href="@route('TAG_GUARD_NAME.home.index')">@choice('TAG_GUARD_NAME.profile', 2)</a></li>
    <li><a href="@route('TAG_GUARD_NAME.login.logout')"><i class="material-icons white-text">close</i></a></li>
  </ul>
</nav>