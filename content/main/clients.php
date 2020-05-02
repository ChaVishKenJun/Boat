<h1>Clients</h1>

<?php
//$cookies->putData('rememberpw',"AAA");
//echo ">>" . $cookies->getData('rememberpw') . "<br><br>";
//print_r($_COOKIE);
global $session;
$session->unsetAllForm();
$result_singlequery_dynamic = $db->singlequery_dynamic('SELECT PersonId,FirstName, LastName, MobileNumber from Person Where Role = "Client"');

$fields = $result_singlequery_dynamic[1]['con'][0];
//print_r($result_singlequery_dynamic);
echo "<table class='table-default'>";
echo "<tr>";
echo "<th>Id</th>";
echo "<th colspan='2'>Name</th>";
echo "<th>Mobile number</th>";
echo "<th></th>";
echo "<th></th>";
echo "</tr> ";
foreach ($result_singlequery_dynamic[0] as $row) {
	$count=0;
	echo "<tr>";
	while($count<=$fields-1) {
		echo "<td>" . $row[$count] . "</td>";
		$count++;
	}
	echo "<td><a href='?action=aEditClient&PersonId=$row[0]'><img src='../chahanlibrary/image/Edit.png'></img></a></td>";
        echo "<td><a href='?action=aDeleteClient&PersonId=$row[0]'><img src='../chahanlibrary/image/Delete.png'></img></a></td>";
        echo "</tr>";
        
}
echo "</table>";

?>