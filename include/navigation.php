<nav id="header" class="navbar navbar-dark fixed-top bg-light flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="?menu=mHome">
        <img id="logo" src="image/Logo.png" />
        Boat
    </a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <?php
            global $session;
            if (strpos($session->getData('LOGGEDIN'), 'true') == true) {
                echo "<a class=\"nav-link\" href=\"?action=signout\">Sign out</a>";
            } else {
                echo "<a class=\"nav-link\" href=\"?menu=signin\">Sign in</a>";
            }
        ?>
        </li>
    </ul>
</nav>