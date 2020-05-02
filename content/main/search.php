<h1>Search Items</h1>
<form name="searchItem" enctype="multipart/form-data" action="?menu=mSearch" method="post">
    <label>Search: </label><input placeholder="Title, Category.." name="titleOrType" type="text" value=""/>
    <button type="submit" class="button" ><img src='../chahanlibrary/image/Search.png'></button>
</form>
<?php
global $session;
global $db;
$session->unsetAllForm();
if($_POST['titleOrType'])
{
    $search = $_POST['titleOrType'];
    $result = $db->Search($search);
    if ($result->num_rows > 0) {
        // output data of each row
        echo "<table class='table-default'>";
        echo "<tr>";
        echo "<th>Id</th>";
        echo "<th>Title</th>";
        echo "<th colspan='2'>Author</th>";
        echo "<th>Category</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr> ";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>". $row["ItemId"]."</td>";
            echo "<td>". $row["Title"]."</td>";
            echo "<td colspan='2'>". $row["FirstName"]. " ".$row["LastName"] ."</td>";
            echo "<td>". $row["categoryname"]."</td>";
            echo "<td><a href='?menu=mcreateOrEditItem'><img src='../chahanlibrary/image/Edit.png'></img></a></td>";
            echo "<td><a href='?action=aDeleteItem'><img src='../chahanlibrary/image/Delete.png'></img></a></td>";
            echo "</tr>";
        }
        echo "</table>";

        } else {
        echo "<span class=\"validation\">No results found.</span>";
        }
    
}







//$result_singlequery_dynamic = $db->singlequery_dynamic("SELECT i.ItemId, i.Title, p.FirstName, p.LastName, c.categoryname FROM item i INNER JOIN person p ON i.PersonId = p.PersonId INNER JOIN itemcategory c ON i.ItemCategoryId = c.ItemCategoryId where i.Title like \"%'$search'%\" or c.CategoryName like  \"%'$search'%\"");
//$fields = $result_singlequery_dynamic[1]['con'][0];
//
////print_r($result_singlequery_dynamic);
//echo "<table class='table-default'>";
//echo "<tr>";
//echo "<th>Id</th>";
//echo "<th>Title</th>";
//echo "<th colspan='2'>Author</th>";
//echo "<th>Category</th>";
//echo "<th></th>";
//echo "<th></th>";
//echo "</tr> ";
//foreach ($result_singlequery_dynamic[0] as $row) {
//	$count=0;
//	echo "<tr>";
//	while($count<=$fields-1) {
//		echo "<td>" . $row[$count] . "</td>";
//		$count++;
//	}
//	echo "<td><a href='?menu=mcreateOrEditItem'><img src='../chahanlibrary/image/Edit.png'></img></a></td>";
//        echo "<td><a href='?action=aDeleteItem'><img src='../chahanlibrary/image/Delete.png'></img></a></td>";
//        echo "</tr>";
//        
//}
//echo "</table>";

?>