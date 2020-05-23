<nav id="header" class="navbar navbar-dark fixed-top bg-light flex-mdmd-nowrap p-0 shadow">
    <button id="openSidebarButton" class="btn btn-light mx-3">
      <svg class="bi bi-list" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
      </svg>
    </button>
    <a class="navbar-brand mx-3" href="?menu=mHome">
        <img id="logo" src="image/Logo.png" />
        Boat
    </a>
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