
<form name="createOrNewClient" enctype="multipart/form-data" action="?action=aCreateOrEditClient" method="post">
<?php
if(!isset($_SESSION['public']['cPersonIdValue']))
{
    echo "<h1>Create Client</h1>";
}else{echo "<h1>Edit Client</h1>";}

if( isset($_SESSION['public']['cClientExists']) AND $_SESSION['public']['cClientExists'] == 0)
{
    echo "<span class=\"validation\">The client already exists.</span><br />";
}
if( isset($_SESSION['public']['cfirstNameEmpty']) AND $_SESSION['public']['cfirstNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The first name of the client cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['clastNameEmpty']) AND $_SESSION['public']['clastNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The last name of the client cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['cMobileNumberEmpty']) AND $_SESSION['public']['cMobileNumberEmpty'] == 0)
{
    echo "<span class=\"validation\">The mobile number of the client cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['cMobileNumberString']) AND $_SESSION['public']['cMobileNumberString'] == 0)
{
    echo "<span class=\"validation\">The mobile number of the client cannot be string.</span><br />";
}
?>
    <input type="hidden" name="personId" <?php
            global $session;
            if(isset($_SESSION['public']['cPersonIdValue']))
                {
                    echo 'value="'.$session->getData(cPersonIdValue).'"';
                } ?> />
    <label>First name:</label> <input name="firstname" type="text" 
            <?php
            global $session;
            if(isset($_SESSION['public']['cFirstNameValue']))
                {
                    echo 'value="'.$session->getData(cFirstNameValue).'"';
                } ?> /><br />
        <label>Last name:</label> <input name="lastname" type="text" <?php global $session; if( isset($_SESSION['public']['cLastNameValue']))
                {
                    echo 'value="'.$session->getData(cLastNameValue).'"';
                } ?>/> <br />
        <label>Mobile number:</label> <input name="mobilenumber" type="text" <?php global $session;  if( isset($_SESSION['public']['cMobileNumberValue']))
                {
                    echo 'value="'.$session->getData(cMobileNumberValue).'"';
                } ?>/> <br />
   <br /><br />
    <input class="button" name="save" type="submit" value="Save"  />
    <a class="button" href='?menu=mClients'>Cancel</a>
</form><br />