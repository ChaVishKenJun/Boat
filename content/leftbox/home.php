<!-- Group List -->
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-toggle="modal" data-target="#exampleModalCenter">
                    <svg class="bi bi-plus-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 01.5.5v4a.5.5 0 01-.5.5H4a.5.5 0 010-1h3.5V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 01.5-.5h4a.5.5 0 010 1H8.5V12a.5.5 0 01-1 0V8z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                    </svg>
                    <span>New group</span>
                </a>
                <?php
                global $session;
                
                $userId = $session->getData("UserId");
                $groupIds = $db->single_dynamic_query("SELECT group_id FROM user_group WHERE user_id=$userId");
                
                if ($groupIds != "false") {
                    foreach ($groupIds[0] as $groupId) {
                        $result = $db->single_dynamic_query("SELECT * FROM groupchat WHERE id=$groupId[0]");
                        
                        foreach ($result[0] as $group) {
                            echo '<a class="nav-link" href="#" group-id="' . $group[0] . '">';
                            echo '<span>' . $group[1] . '</span>';
                            echo '</a>';
                        }
                    }

                }
                ?>
      </li>
    </ul>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">New Group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="?action=aCreateGroup" method="post">
          <div class="form-group row">
            <label for="inputGroupName" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input name="name" type="text" class="form-control" id="inputGroupName" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="userQuery" class="col-sm-2 col-form-label">Add Member</label>
            <div class="col-sm-10">
              <input id="userQuery" class="form-control" />
            </div>
          </div>
          <div class="form-group row">
            <label for="inputGroupName" class="col-sm-2 col-form-label">Members</label>
            <div id="members" class="col-sm-10">
            </div>
          </div>
          <input name="users" id="userIds" hidden />
          <div class="modal-footer">
          <?php
            $groupalreadyexist = $session->getData('groupalreadyexistmessage');
            $session->unsetData('groupalreadyexistmessage');

            if ($groupalreadyexist==1 and is_numeric($groupalreadyexist))
                echo "<b>Group with the same name already exists.</b><br>";
          ?>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary" type="submit">Create</button>
          </div>
      </form>
    </div>
  </div>
</div>