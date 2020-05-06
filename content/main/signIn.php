<h1>Sign In</h1>

<?php
  $signInAttempt = $session->getData('SignInAttemptMessage');
  $session->unsetData('SignInAttemptMessage');
  if (is_numeric($signInAttempt) and $signInAttempt == 1) {
    echo "<p>E-mail address and password not found!</p>";
  }
  
  $signInMessage = $session->getData('SignInMessage');
  $session->unsetData('SignInMessage');
  if (!empty($signInMessage)) {
    echo "<p>$signInMessage</p>";
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