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

                
                echo '<a class="nav-link" href="#">';
                echo '<svg class="bi bi-plus-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">';
                echo '<path fill-rule="evenodd" d="M8 3.5a.5.5 0 01.5.5v4a.5.5 0 01-.5.5H4a.5.5 0 010-1h3.5V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>';
                echo '<path fill-rule="evenodd" d="M7.5 8a.5.5 0 01.5-.5h4a.5.5 0 010 1H8.5V12a.5.5 0 01-1 0V8z" clip-rule="evenodd"/>';
                echo '<path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>';
                echo '</svg>';
                echo '<span>Group 1</span>';
                echo '</a>';
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
        <form>
            <div class="form-group row">
                <label for="inputGroupName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                <input type="email" class="form-control" id="inputGroupName">
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Create</button>
      </div>
    </div>
  </div>
</div>


<?php
/*
//$cookies->putData('rememberpw',"AAA");
//echo ">>" . $cookies->getData('rememberpw') . "<br><br>";
//print_r($_COOKIE);
$session->unsetAllForm();
$result_singlequery_dynamic = $db->singlequery_dynamic('SELECT PersonId,FirstName, LastName, MobileNumber from Person Where Role = "Client"');

$fields = $result_singlequery_dynamic[1]['con'][0];
//print_r($result_singlequery_dynamic);
echo "<table class='table-default'>";
echo "<tr>";
echo "<th>Id</th>";
echo "<th colspan='2'>Name</th>";
echo "<th>Mobile number</th>";
echo "<th></th>";
echo "<th></th>";
echo "</tr> ";
foreach ($result_singlequery_dynamic[0] as $row) {
	$count=0;
	echo "<tr>";
	while($count<=$fields-1) {
		echo "<td>" . $row[$count] . "</td>";
		$count++;
	}
	echo "<td><a href='?action=aEditClient&PersonId=$row[0]'><img src='../chahanlibrary/image/Edit.png'></img></a></td>";
        echo "<td><a href='?action=aDeleteClient&PersonId=$row[0]'><img src='../chahanlibrary/image/Delete.png'></img></a></td>";
        echo "</tr>";
        
}
echo "</table>";


*/
?>