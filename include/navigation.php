<nav id="header" class="navbar navbar-dark fixed-top bg-light flex-md-nowrap p-0 shadow">
    <a class="navbar-brand" href="?menu=mHome">
        <img id="logo" src="image/Logo.png" />
        Boat
    </a>
    <ul id="navigation-link" class="navbar-nav ml-auto">
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
      <div id="notifications" class="modal-body">
        <?php
            //change to read
            $db->updateNotificationsIsReadToRead($userId);
        ?>    
         
      </div>
    </div>
  </div>
</div>