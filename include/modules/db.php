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

	/* Static Functions */

	function getUserID($email) {
		//its a static prepared and encryptet sql SELECT
		$this->open_db();
		$sql="SELECT id from user where email='$email'";
		$result = $this->db_connection->query($sql);
		$row = $result->fetch_assoc();
		//$row = mysql_fetch_array($result);
		$personId = $row["id"];
		return $personId;
	}

	function createNotification($userId, $message,$messageId) {
		$date = date("Y-m-d H:i:s");

		$this->open_db();
		$sql="INSERT INTO notification (message, is_read, date, message_id, user_id)" . "VALUES ('$message', 0, '$date', $messageId, $userId)";
		$this->db_connection->query($sql);
		$groupId = $this->db_connection->insert_id;
		$this->db_connection->close();
		return $groupId;
	}


	/**
	 * This function creates a new group with specified name in the database.
	 * @param string $name name of the new group
	 * @return id of created group
	 */
	function createGroup($name) {
		$this->open_db();
		$sql="INSERT INTO groupchat (name)" . "VALUES ('$name')";
		$this->db_connection->query($sql);
		$groupId = $this->db_connection->insert_id;
		$this->db_connection->close();
		return $groupId;
	}

	/**
	 * 
	 */
	function addUserToGroup($groupId, $userId) {
		$this->open_db();
		$sql="INSERT INTO user_group (user_id, group_id) VALUES ($userId, $groupId)";
		$this->db_connection->query($sql);
		$this->db_connection->close();
	}

	function sendMessage($groupId, $userId, $message) {
		$date = $this->getCurrentDateTime();
		
		$this->open_db();
		$sql = "INSERT INTO message (groupchat_id, date, user_id) VALUES ('$groupId', '$date', '$userId')";
		$this->db_connection->query($sql);
		$messageId = $this->db_connection->insert_id;

		$message = $this->db_connection->real_escape_string($message);
		$sql = "INSERT INTO message_text (id, data) VALUES ('$messageId', '$message')";
		$this->db_connection->query($sql);

		$this->db_connection->close();
		return $messageId;
	}


	function updateNotificationsIsReadToRead($userId) {
		$this->open_db();
		$sql="UPDATE notification SET is_read =1 WHERE user_id = $userId";
		$this->db_connection->query($sql);
		$this->db_connection->close();
	}

	function updateMessagesToRead($userId, $groupId) {
		$this->open_db();
		$date = $this->getCurrentDateTime();
		$sql="UPDATE message SET read_date = '$date' WHERE user_id != $userId AND groupchat_id = $groupId";
		$this->db_connection->query($sql);
		$this->db_connection->close();
	}

	function editMessage($messageId, $data) {
		$this->open_db();
		$date = $this->getCurrentDateTime();
		$sql = "
			UPDATE message
			INNER JOIN message_text ON (message.id = message_text.id)
			SET message.edited_date = '$date', message_text.data = '$data'
			WHERE message.id = $messageId";
		$this->db_connection->query($sql);
		$this->db_connection->close();
	}

	function pinMessage($messageId, $groupId) {
		$this->open_db();
		$sql = "UPDATE message SET pinned_date = NULL WHERE groupchat_id = $groupId";
		$this->db_connection->query($sql);
		$date = $this->getCurrentDateTime();
		$sql = "UPDATE message SET pinned_date = '$date' WHERE id = $messageId";
		$this->db_connection->query($sql);
		$this->db_connection->close();
	}

	function deleteMessage($messageId) {
		$this->open_db();
		$date = $this->getCurrentDateTime();
		$sql = "UPDATE message SET deleted_date = '$date' WHERE id = $messageId";
		$this->db_connection->query($sql);
		$this->db_connection->close();
	}

	function createPoll($groupId, $userId, $title, $datetime, $multiSelect) {
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime(date('Y-m-d H:i:s.'.$micro, $t));
		$date = $d->format("Y-m-d H:i:s.u");

		$this->open_db();
		$sql = "INSERT INTO message (groupchat_id, date, user_id) VALUES ('$groupId', '$date', '$userId')";
		$this->db_connection->query($sql);
		$messageId = $this->db_connection->insert_id;

		$sql = "INSERT INTO message_poll (id, title, due, multi_select) VALUES ('$messageId', '$title', $datetime, $multiSelect)";
		$this->db_connection->query($sql);

		$this->db_connection->close();
		return $messageId;
	}

	function addOptionToPoll($pollId, $option) {
		$this->open_db();
		$sql = "INSERT INTO poll_option (name, message_poll_id) VALUES ('$option', '$pollId')";
		$this->db_connection->query($sql);
		$optionId = $this->db_connection->insert_id;
		return $optionId;
	}

	function vote($userId, $optionId) {
		$this->open_db();
		$sql = "INSERT INTO vote (user_id, poll_option_id) VALUES ('$userId', '$optionId')";
		$this->db_connection->query($sql);
		$voteId = $this->db_connection->insert_id;
		$this->db_connection->close();
		return $voteId;
	}

	function endPoll($pollId) {
		$now = $this->getCurrentDateTime();
		$this->open_db();
		$sql = "UPDATE message_poll SET ended_date = '$now' WHERE id = '$pollId'";
		$this->db_connection->query($sql);
		$this->db_connection->close();
	}

	function getCurrentDateTime() {
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		return $d->format("Y-m-d H:i:s.u");
	}

	function getMessageType($messageId) {
		$type = '';
		if ($this->single_dynamic_query("SELECT id FROM message_text WHERE id = '$messageId'") != "false") {
			$type = "text";
		} else if ($this->single_dynamic_query("SELECT id FROM message_image WHERE id = '$messageId'") != "false") {
			$type = "image";
		} else if ($this->single_dynamic_query("SELECT id FROM message_video WHERE id = '$messageId'") != "false") {
			$type = "video";
		} else if ($this->single_dynamic_query("SELECT id FROM message_poll WHERE id = '$messageId'") != "false") {
			$type = "poll";
		}
		return $type;
	}

	function sendImage($groupId, $userId, $path) {
		$date = $this->getCurrentDateTime();

		$this->open_db();
		$sql = "INSERT INTO message (groupchat_id, date, user_id) VALUES ('$groupId', '$date', '$userId')";
		$this->db_connection->query($sql);
		$messageId = $this->db_connection->insert_id;

		$sql = "INSERT INTO message_image (id, path) VALUES ('$messageId', '$path')";
		$this->db_connection->query($sql);

		$this->db_connection->close();

		return $messageId;
	}
}

$db = new Database;
?>