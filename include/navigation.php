<nav id="header" class="navbar navbar-dark fixed-top bg-light flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="?menu=mHome">
        <img id="logo" src="image/Logo.png" />
        Boat
    </a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
          <a class="nav-link" href="#" data-target="#notifcationModal" data-toggle="modal">Notifications</a>
      </li>      
    </ul>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <?php
            global $session;
            if ($session->getData('SignedIn') == 'true') {
                echo "<a class=\"nav-link\" href=\"?action=aSignOut\">Sign out</a>";
            } else {
                echo "<a class=\"nav-link\" href=\"?menu=mSignIn\">Sign in</a>";
            }
        ?>
        </li>
    </ul>
</nav>

<!-- Modal -->
<div class="modal fade" id="notifcationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Notifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div>No Notifications found.</div>
      </div>
    </div>
  </div>
</div>