<h1>Sign up</h1>

<?php
$useralreadyexist = $session->getData('useralreadyexistmessage');
$session->unsetData('useralreadyexistmessage');
?>
<?php 
if ($useralreadyexist==1 and is_numeric($useralreadyexist)) { 
    echo "<b>User with the same e-mail address already exists.</b><br>";
}
else
{
    echo "<b>Account succesfully created.</b><br>";
    echo $useralreadyexist;
}
?>

<form name="SignUpForm" enctype="multipart/form-data" action="?action=aSignUp" method="post">
  <div class="form-group">
  <label>Name</label>  
  <div class="form-row">
    <div class="col">
      <input name="firstname" type="text" class="form-control" placeholder="First name">
    </div>
    <div class="col">
      <input name="lastname" type="text" class="form-control" placeholder="Last name">
    </div>
  </div>
  </div>
  <div class="form-group">
    <label>Email address</label>
    <input name="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="E-mail">
  </div>
  <div class="form-group">
    <label>Password</label>
    <input name="password" type="password" class="form-control" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary">Sign up</button>
</form>