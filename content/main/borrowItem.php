<h1>Borrow Item</h1>
<form name="borrowItem" enctype="multipart/form-data" action="?action=aBorrowItem" method="post">
<?php
if( isset($_SESSION['public']['bTitleEmpty']) AND $_SESSION['public']['bTitleEmpty'] == 0)
{
    echo "<span class=\"validation\">The title field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['bDateFromEmpty']) AND $_SESSION['public']['bDateFromEmpty'] == 0)
{
    echo "<span class=\"validation\">The first date field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['bDateToEmpty']) AND $_SESSION['public']['bDateToEmpty'] == 0)
{
    echo "<span class=\"validation\">The second date field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['bFirstNameEmpty']) AND $_SESSION['public']['bFirstNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The first name field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['bLastNameEmpty']) AND $_SESSION['public']['bLastNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The last name field cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['bDateFromWrongValue']) AND $_SESSION['public']['bDateFromWrongValue'] == 0)
{
    echo "<span class=\"validation\">Please enter the right date format.</span><br />";
}
if( isset($_SESSION['public']['bDateToWrongValue']) AND $_SESSION['public']['bDateToWrongValue'] == 0)
{
    echo "<span class=\"validation\">Please enter the right date format.</span><br />";
}
if( isset($_SESSION['public']['bItemNotExist']) AND $_SESSION['public']['bItemNotExist'] == 0)
{
    echo "<span class=\"validation\">The item does not exist.</span><br />";
}
if( isset($_SESSION['public']['bClientNotExist']) AND $_SESSION['public']['bClientNotExist'] == 0)
{
    echo "<span class=\"validation\">The client does not exist.</span><br />";
}
if( isset($_SESSION['public']['bItemBorrowed']) AND $_SESSION['public']['bItemBorrowed'] == 0)
{
    echo "<span class=\"validation\">The item is already borrowed by another client.</span><br />";
}
if( isset($_SESSION['public']['bItemNotAvailable']) AND $_SESSION['public']['bItemNotAvailable'] == 0)
{
    echo "<span class=\"validation\">The item is reserved which affects the date.</span><br />";
}
?>
     <label>Title:</label> <input name="title" type="text"                       
                      <?php
            global $session;
            if(isset($_SESSION['public']['bTitleValue']))
                {
                    echo 'value="'.$session->getData(bTitleValue).'"';
                } ?>/><br />
        
        
     <label>Date:</label> <input class="short" placeholder="  From" name="dateFrom" type="text" <?php
            if(isset($_SESSION['public']['bDateFromValue']))
                {
                    echo 'value="'.$session->getData(bDateFromValue).'"';
                } ?>/>
            <input class="short" name="dateTo" placeholder="  To" type="text" <?php
            if(isset($_SESSION['public']['bDateToValue']))
                {
                    echo 'value="'.$session->getData(bDateToValue).'"';
                } ?>/> <br />
            <b>Person</b> <br />
        <label>First name:</label> <input name="firstName" type="text" <?php
            if(isset($_SESSION['public']['bFirstNameValue']))
                {
                    echo 'value="'.$session->getData(bFirstNameValue).'"';
                } ?>/> <br />
        <label>Last name:</label> <input name="lastName" type="text" <?php
            if(isset($_SESSION['public']['bLastNameValue']))
                {
                    echo 'value="'.$session->getData(bLastNameValue).'"';
                } ?>/> <br />
   <br /><br />
    <input name="save" class="button" type="submit" value="Save"  />
    <a href='?menu=mItems' class="button">Cancel</a>
</form><br />
