<div id="messages" class="pt-3 pb-2 mb-5"></div>
<div id="input" class="card bg-light col-md-9 ml-sm-auto col-lg-10 px-4 py-2 fixed-bottom hidden" hidden>
	<form>
		<div class="form-row">
			<div class="col-10">
				<input type="text" class="form-control">
			</div>
			<div class="col-1">
				<a tabindex="0" class="btn btn-lg btn-secondary btn-block text-white" role="button" data-toggle="popover">+</a>
			</div>
			<div class="col-1">
				<button class="btn btn-primary btn-lg btn-block" type="submit" onclick=sendMessage(this)>Send</button>
			</div>
		</div>
	</form>
</div>
    
    <?php
    /*
//$cookies->putData('rememberpw',"AAA");
//echo ">>" . $cookies->getData('rememberpw') . "<br><br>";
//print_r($_COOKIE);
global $session;
global $db;
$session->unsetAllForm();
$result_singlequery_dynamic = $db->singlequery_dynamic('SELECT i.Title, p.FirstName, p.LastName, COUNT(ah.ItemId) FROM activityhistory ah INNER JOIN item i ON ah.ItemId = i.ItemId INNER JOIN person p ON i.PersonId = p.PersonId WHERE ah.Activity = "Borrow" GROUP By ah.ItemId LIMIT 10');
if($result_singlequery_dynamic == "true")
{
    echo "<h1>Books of this month - ". date("F Y")."</h1>";
    $fields = $result_singlequery_dynamic[1]['con'][0];
echo "<table class='table-default'>";
echo "<tr>";
echo "<th>Title</th>";
echo "<th colspan='2'>Author</th>";
echo "<th>Lent times</th>";
echo "</tr> ";
foreach ($result_singlequery_dynamic[0] as $row) {
	$count=0;
	echo "<tr>";
	while($count<=$fields-1) {
		echo "<td>" . $row[$count] . "</td>";
		$count++;
	}
        echo "</tr>";
        
}
echo "</table>";
}else{
    echo "<h1>
    No Books of this month -". date("F Y")."</h1>";
}

*/
?>
