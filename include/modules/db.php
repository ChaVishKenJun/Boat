<?php 
class Database {
	
		function opendb() {
			$this->condb = $db = @new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
			$db->set_charset("utf8");
		}
		
		function multiquery_dynamic_select($sql) {			
			$this->opendb();
			if ($this->condb->multi_query($sql)) { 
				$querynumber=0; $numcount=0;
				do { 
					$stmt = $this->condb->store_result();
					
					$numrows = $stmt->num_rows-1;
						while ($row = $stmt->fetch_array(MYSQLI_NUM)) { 
							$fields = $stmt->field_count;
							$count=0;
							while($count<=$fields-1) {
								$all_arr[$querynumber][$numcount][]=$row[$count];
								$count++;
							}
							while($numcount<=$numrows) {
								$numcount++;
							}
						}
					$stmt->free(); 
					if ($this->condb->more_results()) { 
						$querynumber++;
					}
				} while($this->condb->next_result());
			} 
			$stmt->close();
			return $all_arr;
		}
	
		function multiquery_dynamic_sqlcommand($sql) {
			$this->opendb();
			$affcounter=1;
			if ($this->condb->multi_query($sql)) { 
				do { 
					$affected=$affcounter;
					$affcounter++;
				} while($this->condb->next_result());
			} 
			return $affected;
		}
		
		function singlequery_dynamic($sql) {
			$this->opendb();
			$stmt =$this->condb->query($sql);
			$conditions['con'][0] = $stmt->field_count; 
                        //if there is data fetched or else skip
                        if ($stmt->field_count!= 0) {
			while ($all = $stmt->fetch_array(MYSQLI_NUM)){
				$all_arr[]=$all;
    		}
                        }
                            $this->condb->close();
			
			if(!isset($all_arr)) {
				return "false";	
			}
			return array($all_arr,$conditions);
		}
		
		function prepared_dynamic_select($sql,$exenumber=1) {
			$this->opendb();
			$stmt = $this->condb->prepare($sql); 
			$fields = $stmt->field_count;
			$count=0;
			while($count<=$fields-1) {
        		$fieldss[$count]=&$$count;
				$count++;
    		}
			call_user_func_array(array($stmt,'bind_result'),$fieldss);
			$exec=1;
			while($exec<=$exenumber) {
				$stmt->execute();  
				while ($stmt->fetch()) {
					$all_arr[]=$fieldss;
				}
			$exec++;
			}
 			return $all_arr;
 			$stmt->close();   
		}
		
		function prepared_dynamic_sqlcommands($sql,$exenumber=1) {
			$this->opendb();
			$stmt = $this->condb->prepare($sql); 
			$exec=1;
			while($exec<=$exenumber) {				
				$stmt->execute(); 
				$exec++;
			}
			return $exenumber;
		}
		
		////////////////////////////////////////////////////////////////////////////////
		// static functions
		
		function getid_detail($condition) {
			//its a static prepared and encryptet sql SELECT
			$sql="SELECT id from detail where id=$condition";
		}
		
			function put_detail($condition) {
			//its a static prepared and encryptet sql INSERT
			$sql="SELECT id from detail where id=$condition";
		}
		function getid_person($firstname, $lastname) {
			//its a static prepared and encryptet sql SELECT
                        $this->opendb();
                        $sql="SELECT personId from person where firstname='$firstname' AND lastname='$lastname'";
                    $result = $this->condb->query($sql);
                    $row = $result->fetch_assoc();
                    //$row = mysql_fetch_array($result);
                    $personId = $row["personId"];
			return $personId;
		}
                function getid_item($title){
			//its a static prepared and encryptet sql SELECT
                        $this->opendb();
                        $sql="SELECT ItemId from item where title='$title'";
                    $result = $this->condb->query($sql);
                    $row = $result->fetch_assoc();
                    //$row = mysql_fetch_array($result);
                    $personId = $row["ItemId"];
			return $personId;
		}
                
                public function Search($search)
                {
                    $this->opendb();
                    $sql = "SELECT i.ItemId, i.Title, p.FirstName, p.LastName, c.categoryname FROM item i INNER JOIN person p ON i.PersonId = p.PersonId INNER JOIN itemcategory c ON i.ItemCategoryId = c.ItemCategoryId where i.Title like '%$search%' or c.CategoryName like '%$search%'";
                    $result = $this->condb->query($sql);
                    return $result;
                }
                public function getItemData($itemId)
                {
                    $this->opendb();
                    $sql = "Select Title, Type, p.FirstName, p.LastName, ItemCategoryId from item inner join person p on item.PersonId = p.PersonId where ItemId = $itemId";
                    $result = $this->condb->query($sql);
                    return $result;
                }
                public function getClientData($clientId)
                {
                    $this->opendb();
                    $sql = "Select FirstName, LastName, MobileNumber from person where personId = $clientId";
                    $result = $this->condb->query($sql);
                    return $result;
                }
		public function deleteItem($itemId)
                {
                    $this->opendb();
                    $sql = "DELETE from activityhistory where ItemId = $itemId; delete from item where ItemId = $itemId;";
                    $this->condb->query($sql);
                }
                public function deleteClient($clientId)
                {
                    $this->opendb();
                    $sql = "DELETE from activityhistory where personId = $clientId; delete from person where personId = $clientId;";
                    
                    $result = $this->condb->query($sql);
                    
                    return $result;
                }

	
}
$db = new Database;


?>