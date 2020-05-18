<nav id="header" class="navbar navbar-dark fixed-top bg-light flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="?menu=mHome">
        <img id="logo" src="image/Logo.png" />
        Boat
    </a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
          <a class="nav-link" href="#" data-target="#notifcationModal" data-toggle="modal">
          <?php
          global $session;
          $userId = $session->getData("UserId");
          global $db;

          if ($session->getData('SignedIn') == 'true') {
            $unreadNotifications = $db->single_dynamic_query('SELECT message, message_id, date FROM notification WHERE is_read = 0 AND user_id='.$userId);
            //no notifications
            if($unreadNotifications=='false') {
              echo "<svg class=\"bi bi-bell\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">
                      <path d=\"M8 16a2 2 0 002-2H6a2 2 0 002 2z\"/>
                      <path fill-rule=\"evenodd\" d=\"M8 1.918l-.797.161A4.002 4.002 0 004 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 00-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 111.99 0A5.002 5.002 0 0113 6c0 .88.32 4.2 1.22 6z\" clip-rule=\"evenodd\"/>
                    </svg>";
            }
            else{
              echo "<svg class=\"bi bi-bell-fill\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"red\" xmlns=\"http://www.w3.org/2000/svg\">
                      <path d=\"M8 16a2 2 0 002-2H6a2 2 0 002 2zm.995-14.901a1 1 0 10-1.99 0A5.002 5.002 0 003 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z\"/>
                    </svg>";
            }
          }
          ?>          
          </a>
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
        <?php
          //no notifications
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
            global $session;
            $db->updateNotificationsIsReadToRead($userId);
          }
        ?>        
      </div>
    </div>
  </div>
</div>