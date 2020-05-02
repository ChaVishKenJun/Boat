

<?php
if(!isset($_SESSION['public']['iItemIdValue']))
{
    echo "<h1>Create Item</h1>";
}
else{echo "<h1>Edit Item</h1>";}
if( isset($_SESSION['public']['iTitleEmpty']) AND $_SESSION['public']['iTitleEmpty'] == 0)
{
    echo "<span class=\"validation\">The title of the item cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['iTypeEmpty']) AND $_SESSION['public']['iTypeEmpty'] == 0)
{
    echo "<span class=\"validation\">Please select the type.</span><br />";
}
if( isset($_SESSION['public']['iFirstNameEmpty']) AND $_SESSION['public']['iFirstNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The first name of the author cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['iLastNameEmpty']) AND $_SESSION['public']['iLastNameEmpty'] == 0)
{
    echo "<span class=\"validation\">The last name of the author cannot be empty.</span><br />";
}
if( isset($_SESSION['public']['iCategoryEmpty']) AND $_SESSION['public']['iCategoryEmpty'] == 0)
{
    echo "<span class=\"validation\">Please select a category.</span><br />";
}
if( isset($_SESSION['public']['iItemExists']) AND $_SESSION['public']['iItemExists'] == 0)
{
    echo "<span class=\"validation\">The item already exist.</span><br />";
}
?>
<!--
$session->PutData('iTitleValue', $title);
            $session->PutData('iTypeValue', $type);
            $session->PutData('iFirstNameValue', $firstname);
            $session->PutData('iLastNameValue', $lastname);
            $session->PutData('iCategoryValue', $category);-->

 <form name="createOrNewItem" enctype="multipart/form-data" action="?action=aCreateOrEditItem" method="post">
     <input type="hidden" name="itemId" <?php
            global $session;
            if(isset($_SESSION['public']['iItemIdValue']))
                {
                    echo 'value="'.$session->getData(iItemIdValue).'"';
                } ?> />
	<label>Title: </label><input name="title" type="text" <?php
            if(isset($_SESSION['public']['iTitleValue']))
                {
                    echo 'value="'.$session->getData(iTitleValue).'"';
                } ?> /> <br />
        <label><b>Type</b></label><br />
        <label>Book</label><input type="radio"  name="type" <?php if($session->getData(iTypeValue) == 0){echo "checked";}?> value="0"><br />
        <label>Video</label><input type="radio"  name="type" <?php if($session->getData(iTypeValue) == 1){echo "checked";}?> value="1"><br />
        <label><b>Author / Director</b></label><br />
	<label>First name: </label><input name="firstname" type="text" <?php
            if(isset($_SESSION['public']['iFirstNameValue']))
                {
                    echo 'value="'.$session->getData(iFirstNameValue).'"';
                } ?> /><br />
        <label>Last name: </label><input name="lastname" type="text" <?php
            if(isset($_SESSION['public']['iLastNameValue']))
                {
                    echo 'value="'.$session->getData(iLastNameValue).'"';
                } ?> /><br />
            <label><b>Category </b></label> <br />
        
        <?php
    $result_singlequery_dynamic = $db->singlequery_dynamic('SELECT * FROM itemcategory');
        $fields = $result_singlequery_dynamic[1]['con'][0];
        //print_r($result_singlequery_dynamic);
        foreach ($result_singlequery_dynamic[0] as $row) {
                $count=0;
                while($count<=$fields/2-1) {
                        $labelCount = $count * 2 + 1;
                        $valueCount = $count * 2;
                        echo "<label>$row[$labelCount]</label>";
                        if($session->getData(iCategoryValue) == $row[$valueCount]){
                            
                            echo "<input type=\"radio\"  name=\"category\" checked value=$row[$valueCount]><br />";
                            }
                            else{echo "<input type=\"radio\"  name=\"category\" value=$row[$valueCount]><br />";}
                        
                        $count++;
                }
        }
        ?>
   <br /><br />
    <input class="button" name="save" type="submit" value="Save"  />
    <a class="button" href='?menu=mItems'>Cancel</a>
</form><br />