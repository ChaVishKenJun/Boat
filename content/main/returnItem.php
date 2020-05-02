<h1>Return Item</h1> 
<form name="returnItem" enctype="multipart/form-data" action="?action=aReturnItem" method="post">
<?php
if( isset($_SESSION['public']['rTitleEmpty']) AND $_SESSION['public']['rTitleEmpty'] == 0)
{
    echo "<span class=\"validation\">The title field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['rTypeEmpty']) AND $_SESSION['public']['rTypeEmpty'] == 0)
{
    echo "<span class=\"validation\">Please select a type.</span><br />";
}
if( isset($_SESSION['public']['rFirstNameEmpty']) AND $_SESSION['public']['rFirstNameEmpty'] == 0)
{
    echo "<span class=\"validation\">Please enter the first name of the client.</span><br />";
}
if( isset($_SESSION['public']['rLastNameEmpty']) AND $_SESSION['public']['rLastNameEmpty'] == 0)
{
    echo "<span class=\"validation\">Please enter the first name of the client.</span><br />";
}
if( isset($_SESSION['public']['rItemNotExist']) AND $_SESSION['public']['rItemNotExist'] == 0)
{
    echo "<span class=\"validation\">The item does not exist.</span><br />";
}
if( isset($_SESSION['public']['rClientNotExist']) AND $_SESSION['public']['rClientNotExist'] == 0)
{
    echo "<span class=\"validation\">The client does not exist.</span><br />";
}
?>
     <label>Title:</label> <input name="title" type="text" <?php
            global $session;
            if(isset($_SESSION['public']['rTitleValue']))
                {
                    echo 'value="'.$session->getData(rTitleValue).'"';
                } ?>/><br />
     <label><b>Type</b></label> <br />
        <label>Book</label><input type="radio"  name="type" <?php if($session->getData(rTypeValue) == 0){echo "checked";}?> value="0"><br />
        <label>Video</label><input type="radio"  name="type" <?php if($session->getData(rTypeValue) == 1){echo "checked";}?> value="1"><br />
        <label><b>Person</b></label> <br />
        <label>First name:</label> <input name="firstName" type="text" <?php
            if(isset($_SESSION['public']['rFirstNameValue']))
                {
                    echo 'value="'.$session->getData(rFirstNameValue).'"';
                } ?>/> <br />
        <label>Last name:</label> <input name="lastName" type="text" <?php
            if(isset($_SESSION['public']['rLastNameValue']))
                {
                    echo 'value="'.$session->getData(rLastNameValue).'"';
                } ?>/> <br />
   <br /><br />
    <input name="save" class="button" type="submit" value="Save"  />
    <a class="button" href='?menu=mItems'>Cancel</a>
</form><br />
