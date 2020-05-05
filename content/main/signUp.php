<h1>Sign up</h1>

<?php
$signinattempt = $session->getData('signinattemptmessage');
$session->unsetData('signinattemptmessage');
?>
<?php 
if ($signinattempt==1 and is_numeric($signinattempt)) { 
    echo "<b>E-mail address and password not found!</b><br>";
}
else
{
    echo $signinattempt;
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