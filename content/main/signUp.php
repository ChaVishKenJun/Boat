<h1>Sign up</h1>

<?php
  $useralreadyexist = $session->getData('useralreadyexistmessage');
  $session->unsetData('useralreadyexistmessage');

  if ($useralreadyexist==1 and is_numeric($useralreadyexist))
      echo "<b>User with the same e-mail address already exists.</b><br>";

  if ($usercreated==1 and is_numeric($usercreated))
    echo "<b>Account successfully created.</b><br>";
?>

<form name="SignUpForm" enctype="multipart/form-data" action="?action=aSignUp" method="post">
  <div class="form-group">
  <label>Name</label>  
  <div class="form-row">
    <div class="col">
      <input name="firstname" type="text" class="form-control" placeholder="First name" required>
    </div>
    <div class="col">
      <input name="lastname" type="text" class="form-control" placeholder="Last name" required> 
    </div>
  </div>
  </div>
  <div class="form-group">
    <label>Email address</label>
    <input name="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="E-mail" required>
  </div>
  <div class="form-group">
    <label>Password</label>
    <input name="password" type="password" class="form-control" placeholder="Password" required>
  </div>
  <button type="submit" class="btn btn-primary">Sign up</button>
</form>