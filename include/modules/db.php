<?php
class Database {
	function open_db() {
		$this->db_connection = $db = @new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$db->set_charset("utf8");
	}

	/* Database functions */

	// dynamic_singlequery before
	function single_dynamic_query($query) {
		$this->open_db();
		$statement = $this->db_connection->query($query);
		$conditions["con"][0] = $statement->field_count;
		
		// Check if there is any data fetched
		if ($statement->field_count > 0) {
			while ($result = $statement->fetch_array(MYSQLI_NUM)) {
				$result_array[] = $result;
			}
		}

		$this->db_connection->close();

		if (!isset($result_array)) {
			return 'false';
		}

		return array($result_array, $conditions);
	}

	function multi_dynamic_select($query) {
		$this->open_db();
		
		if ($this->db_connection->multi_query($query)) {
			$query_number = 0;
			$current_row_count = 0;
			
			do {
				$statement = $this->db_connection->store_result();
				$total_row_count = $statement->num_rows - 1;
				
				while ($row = $statement->fetch_array(MYSQLI_NUM)) {
					$total_field_count = $statement->field_count;
					$current_field_count = 0;
					
					while ($current_field_count <= $total_field_count - 1) {
						$result_array[$query_number][$current_row_count][] = $row[$current_field_count];
						$current_field_count++;
					}
					
					while ($current_row_count <= $total_row_count) {
						$current_row_count++;
					}
				}
				
				$statement->free();
				
				if ($this->db_connection->more_results()) {
					$query_number++;
				}
			} while ($this->db_connection->next_result());
		}
		
		$statement->close();
		return $result_array;
	}

	// multiquery_dynamic_sqlcommand before
	function multi_dynamic_command($command) {
		$this->open_db();
		$count = 1;
		
		if ($this->db_connection->multi_query($command)) {
			do {
				$count++;
			} while($this->db_connection->next_result());
		}

		return $count;
	}

	function prepared_dynamic_select($query, $number_of_execution = 1) {
		$this->open_db();
		$statement = $this->db_connection->prepare($query);
		$total_field_count = $statement->field_count;
		$current_field_count = 0;

		while ($current_field_count <= $total_field_count - 1) {
			$fields[$current_field_count] = &$$current_field_count;
			$current_field_count++;
		}

		call_user_func_array(array($statement, 'bind_result'), $fields);

		$execution_count = 1;

		while($execution_count <= $number_of_execution) {
			$statement->execute();
			while ($statement->fetch()) {
				$result_array = $fields;
			}
			$execution_count++;
		}

		$statement->close();
		return $result_array;
	}

	//prepared_dynamic_sqlcommands before
	function prepared_dynamic_command($command, $number_of_execution = 1) {
		$this->open_db();
		$statement = $this->db_connection->prepare($command); 
		$execution_count = 1;
		while($execution_count <= $number_of_execution) {				
			$statement->execute(); 
			$execution_count++;
		}
		return $execution_count;
	}

	/* Static Functions - Examples */
	
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
		$this->open_db();
		$sql="SELECT personId from person where firstname='$firstname' AND lastname='$lastname'";
		$result = $this->db_connection->query($sql);
		$row = $result->fetch_assoc();
		//$row = mysql_fetch_array($result);
		$personId = $row["personId"];
		return $personId;
	}
	
	function getid_item($title) {
		//its a static prepared and encryptet sql SELECT
		$this->open_db();
		$sql="SELECT ItemId from item where title='$title'";
		$result = $this->db_connection->query($sql);
		$row = $result->fetch_assoc();
		//$row = mysql_fetch_array($result);
		$personId = $row["ItemId"];
		return $personId;
	}
	
	public function Search($search) {
		$this->open_db();
		$sql = "SELECT i.ItemId, i.Title, p.FirstName, p.LastName, c.categoryname FROM item i INNER JOIN person p ON i.PersonId = p.PersonId INNER JOIN itemcategory c ON i.ItemCategoryId = c.ItemCategoryId where i.Title like '%$search%' or c.CategoryName like '%$search%'";
		$result = $this->db_connection->query($sql);
		return $result;
	}
	
	public function getItemData($itemId) {
		$this->open_db();
		$sql = "Select Title, Type, p.FirstName, p.LastName, ItemCategoryId from item inner join person p on item.PersonId = p.PersonId where ItemId = $itemId";
		$result = $this->db_connection->query($sql);
		return $result;
	}
	
	public function getClientData($clientId) {
		$this->open_db();
		$sql = "Select FirstName, LastName, MobileNumber from person where personId = $clientId";
		$result = $this->db_connection->query($sql);
		return $result;
	}
	
	public function deleteItem($itemId) {
		$this->open_db();
		$sql = "DELETE from activityhistory where ItemId = $itemId; delete from item where ItemId = $itemId;";
		$this->db_connection->query($sql);
	}
	
	public function deleteClient($clientId) {
		$this->open_db();
		$sql = "DELETE from activityhistory where personId = $clientId; delete from person where personId = $clientId;";
		$result = $this->db_connection->query($sql);
		return $result;
	}
}

$db = new Database;
?>