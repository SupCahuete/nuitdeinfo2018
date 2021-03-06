<!-- En informatique, un menu est un élément d'interface graphique, généralement rectangulaire, dans lequel est présentée une liste de commandes. Les menus sont généralement cachés afin de ne pas encombrer l'espace de travail. Ils apparaissent à la suite d'actions précises, tels que le clic sur une zone particulière, ou sur un élément d'une barre de menu.

Ces menus sont à distinguer des sections « menus » que l'on peut retrouver sur un site web. Ce menu est destiné à simplifier l'exploration des pages d'un site via un système ergonomique de liens séparés en catégories aisément compréhensibles. -->

<nav id="mainMenu">
    <div class="nav-wrapper">
        <ul>
        <li><a href="@route('guest.resources.index')" class="green-text">RESSOURCES</a></li>
        <li><a href="@route('guest.energies.index')" class="green-text">ENERGIE</a></li>
        <li><a href="@route('guest.health.index')" class="green-text">SANTE</a></li>
        <li><a href="@route('guest.telemetries.index')" class="green-text">TELEMETRIE</a></li>
        <li><a href="@route('guest.nav.index')" class="green-text">NAV</a></li>
          <li><a href="@route('guest.chat.index')" class="green-text">CHAT</a></li>
        </ul>
    </div>
</nav>

<div id="topBar">
    <p class="time green-text right"></p>
    <p class="date green-text right"></p>
    <p class="green-text right">|</p>
    <p class="green-text right"><span class="air-temp">--</span> °C (air)</p>
    <p class="green-text right">|</p>
    <p class="green-text right"><span class="ground-temp">--</span> °C (sol)</p>
    <i class="material-icons green-text right">wb_sunny</i>
</div>