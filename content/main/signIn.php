<?php
$signinattempt = $session->getData('signinattemptmessage');
$session->unsetData('signinattemptmessage');
?>

<h1>Sign in</h1>
<?php 
if ($signinattempt==1 and is_numeric($signinattempt)) { 
    echo "<b>E-mail address and password not found!</b><br>";
}
else
{
    echo $signinattempt;
}
?>

<form name="SignInForm" enctype="multipart/form-data" action="?action=aSignIn" method="post">
  <div class="form-group">
    <label>Email address</label>
    <input name="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="E-mail" required>
  </div>
  <div class="form-group">
    <label>Password</label>
    <input name="password" type="password" class="form-control" placeholder="Password" required>
  </div>
  <div class="form-group">
    <a href="?menu=mSignUp">Create an account</a>
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
<br />