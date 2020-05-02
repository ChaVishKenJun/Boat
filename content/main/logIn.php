<?php
$loginversuch = $session->getData('loginattemptmessage');
$session->unsetData('loginattemptmessage');
?>

<h1>Login</h1>
<?php 
if ($loginversuch==1 and is_numeric($loginversuch)) { 
    echo "<b>Keine Übereinstimmung</b> !! Benutzername und oder PW nicht gefunden <br>";
}
else
{
    echo $loginversuch;
}
?>

<form name="Login" enctype="multipart/form-data" action="?action=aLogin" method="post">
    <label>Name: </label>
    <input class="short" name="firstName" type="text" placeholder="First name">
    <input class="short" name="lastName" type="text" placeholder="Last name"> <br />
    <label>Password: </label>
    <input name="password" type="password" value=""> <br />
    <input class="button" name="submit" type="submit" value="Login"  />
</form><br />