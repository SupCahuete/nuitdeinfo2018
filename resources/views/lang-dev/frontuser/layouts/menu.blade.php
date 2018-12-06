<nav class="nav-wrapper z-depth-2 back-or-pale">
  <a href="@route("frontuser.home.index")" class="brand-logo">
    <img id="logo" src="@image('logo.png')" />
  </a>
  <ul id="nav-mobile" class="right">
    <li><a href="@route("frontuser.home.index")">Dashborad</a></li>
    <li><a href="@route("frontuser.home.index")">@choice('frontuser.profile', 2)</a></li>
    <li><a href="@route("frontuser.login.logout")"><i class="material-icons white-text">close</i></a></li>
  </ul>
</nav>
