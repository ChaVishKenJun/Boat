<nav id="header" class="navbar navbar-dark fixed-top bg-light flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="?menu=mHome">
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
      <div class="modal-body">
        <?php
          //no notifications
          global $session;
          global $db;
          $userId = $session->getData("UserId");

          $notifications = $db->single_dynamic_query('SELECT message,message_id, date FROM notification WHERE user_id ='.$userId);
          if($notifications=='false') {
            echo "<div>No Notifications found.</div>";
          }
          else{
            $fields = $notifications[1]['con'][0];
            //print_r($result_singlequery_dynamic);
            echo "<table class='table'>";
            echo "<tbody>";
            foreach ($notifications[0] as $row) {
              $count=0;
              echo "<tr>";
              while($count<=$fields-1) {
                echo "<td>" . $row[$count] . "</td>";
                $count++;
              }
              echo "</tr>";
                    
            }
            echo "</tbody>";
            echo "</table>";
            
            //change to read
            $db->updateNotificationsIsReadToRead($userId);
          }
        ?>    
         
      </div>
    </div>
  </div>
</div>