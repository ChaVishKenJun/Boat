<h1>Reserve Item</h1>
<form name="reserveItem" enctype="multipart/form-data" action="?action=aReserveItem" method="post">
<?php
if( isset($_SESSION['public']['reTitleEmpty']) AND $_SESSION['public']['reTitleEmpty'] == 0)
{
    echo "<span class=\"validation\">The title field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['reDateFromEmpty']) AND $_SESSION['public']['reDateFromEmpty'] == 0)
{
    echo "<span class=\"validation\">The first date field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['reDateToEmpty']) AND $_SESSION['public']['reDateToEmpty'] == 0)
{
    echo "<span class=\"validation\">The second date field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['reFirstNameEmpty']) AND $_SESSION['public']['reFirstNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The first name field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['reLastNameEmpty']) AND $_SESSION['public']['reLastNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The last name field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['reDateFromWrongValue']) AND $_SESSION['public']['reDateFromWrongValue'] == 0)
{
    echo "<span class=\"validation\">Please enter the right date format.</span><br />";
}
if( isset($_SESSION['public']['reDateToWrongValue']) AND $_SESSION['public']['reDateToWrongValue'] == 0)
{
    echo "<span class=\"validation\">Please enter the right date format.</span><br />";
}
if( isset($_SESSION['public']['reItemNotExist']) AND $_SESSION['public']['reItemNotExist'] == 0)
{
    echo "<span class=\"validation\">The item does not exist.</span><br />";
}
if( isset($_SESSION['public']['reClientNotExist']) AND $_SESSION['public']['reClientNotExist'] == 0)
{
    echo "<span class=\"validation\">The client does not exist.</span><br />";
}
if( isset($_SESSION['public']['reItemBorrowed']) AND $_SESSION['public']['reItemBorrowed'] == 0)
{
    echo "<span class=\"validation\">The item is already borrowed by another client.</span><br />";
}
if( isset($_SESSION['public']['reItemNotAvailable']) AND $_SESSION['public']['reItemNotAvailable'] == 0)
{
    echo "<span class=\"validation\">The item is reserved which affects the date.</span><br />";
}
?>
	<label>Title:</label> <input name="title" type="text"                       
                      <?php
            global $session;
            if(isset($_SESSION['public']['reTitleValue']))
                {
                    echo 'value="'.$session->getData(reTitleValue).'"';
                } ?>/><br />
        
        
        <label>Date:</label> <input class="short" placeholder="  From" name="dateFrom" type="text" <?php
            if(isset($_SESSION['public']['reDateFromValue']))
                {
                    echo 'value="'.$session->getData(reDateFromValue).'"';
                } ?>/>
        <input name="dateTo" class="short" placeholder="  To" type="text" <?php
            if(isset($_SESSION['public']['reDateToValue']))
                {
                    echo 'value="'.$session->getData(reDateToValue).'"';
                } ?>/> <br />
            <label><b>Person</b></label> <br />
        <label>First name:</label> <input name="firstName" type="text" <?php
            if(isset($_SESSION['public']['reFirstNameValue']))
                {
                    echo 'value="'.$session->getData(reFirstNameValue).'"';
                } ?>/> <br />
        <label>Last name:</label> <input name="lastName" type="text" <?php
            if(isset($_SESSION['public']['reLastNameValue']))
                {
                    echo 'value="'.$session->getData(reLastNameValue).'"';
                } ?>/> <br />
   <br /><br />
    <input class="button" name="save" type="submit" value="Save"  />
    <a class="button" href='?menu=mItems'>Cancel</a>
</form><br />
