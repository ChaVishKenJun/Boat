<?php
class Action {
    var $action;
    
    // Constructor
    function Action($action) {
        global $security;
        
        switch ($action) {
            case "aSignUp":
                if ($security->dataintegrity($_REQUEST) == 1) {
                    $this->signUp($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
                } else {
                    // TODO: Log XSS attack attempt
                }
            break;
            case "aSignIn":
                if ($security->dataintegrity($_REQUEST) == 1) {
                    $this->signIn($_POST['email'], $_POST['password']);	
                } else {
                    // TODO: Log XSS attack attempt
                }
            break;
            case "aSignOut":
                if ($security->dataintegrity($_REQUEST) == 1) {
                    $this->signOut();
                } else {
                    // TODO: Log XSS attack attempt
                }  
            break;

            case "aQueryUser":
                $this->queryUser($_GET["query"]);
            break;
            case "aCreateGroup":                
                $this->createGroup($_POST['name'], $_POST["users"]);
            break;
            case "aLoadGroups":
                $this->loadGroups();
            break;
            case "aOpenGroup":
                $this->openGroup($_GET["groupId"]);
            break;

            case "aSendMessage":
                $this->sendMessage($_GET["message"], $_GET["mentions"]);
            break;
            case "aLoadMessages":
                $this->loadMessages($_GET["after"]);
            break;
            case "aGetUpdatedMessages" :
                $this->getUpdatedMessages($_GET["updatedLaterThan"]);
            break;
            case "aEditMessage":
                $this->editMessage($_POST["data"]);
            break;
            case "aPinMessage":
                $this->pinMessage($_POST["messageId"]);
            break;
            case "aDeleteMessage":
                $this->deleteMessage($_POST["messageId"]);
            break;

            case "aLoadNotifications":                
                $this->loadNotifications();
            break;
            case "aUpdateNotificationsToRead":
                $this->updateNotificationsToRead();
            break;

            case "aCreatePoll":
                $this->createPoll($_POST["data"]);
            break;
            case "aVote":
                $this->vote($_POST["data"]);
            break;
            case "aEndPoll":
                $this->endPoll($_POST["messageId"], $_POST["force"]);
            break;

            case "aSendImage":
                $this->sendImage($_FILES['file']);
            break;
            case "aLoadImage":
                $this->loadImage($_GET["messageId"]);
            break;

            case "aSendVideo":
                $this->sendVideo($_FILES['file']);
            break;
            case "aLoadVideo":
                $this->loadVideo($_GET["messageId"]);
            break;
            case "aQueryUserFromCurrentGroup":
                $this->QueryUserFromCurrentGroup($_GET["query"]);
        }
    }

    function signUp($firstname, $lastname, $email, $password) {
		global $db;
		global $header;
		global $security;
        global $session;
        
        $encrypted_pw = md5($password);
        
        $user = $db->single_dynamic_query("SELECT id from user WHERE email='$email'");

        if ($user == 'false') {
            // Create user when there is no user with the email address
            $userId = $db->createUser($firstname, $lastname, $email, $encrypted_pw);
            
            // Send welcoming notification to the new user
            $db->createNotification($userId, 'Welcome to Boat!', 'NULL');

            $session->unsetData('UserAlreadyExistMessage');
            $session->putData('SignInMessage', 'You are successfully signed up.');

            $header->setHeader('mSignIn');
        } else {
            $session->putData('UserAlreadyExistMessage', 1);

            $header->setHeader('mSignUp');
        }
    }

	function signIn($email, $password) {
        global $db;
		global $header;
		global $security;
		global $session;
        
        $encrypted_pw = md5($password);

        $user = $db->single_dynamic_query("SELECT id FROM user WHERE email='$email' AND password='$encrypted_pw'");

        if ($user == 'false') {
            $session->putData('SignInAttemptMessage', 1);
            $session->putData('SignedIn', 'false');

            $header->setHeader('mSignIn');
        } else {
            $session->unsetData('SignInAttemptMessage');
            $session->putData('SignedIn', 'true');

            $session->putData('UserId', $user[0][0][0]);

            $header->setHeader('mHome');
        }
	}

	function signOut() {
        global $header;
        global $session;
        
		$session->putData('SignInMessage', 'You are succesfully signed out.');
        $session->putData('SignedIn', 'false');
        $session->unsetData('UserId');

		$header->setHeader('mSignIn');
    }
    
    function queryUser($query) {
        global $db;  

        $result = '';      
        $users = $db->single_dynamic_query("SELECT id, firstname, lastname, email FROM user WHERE firstname LIKE '%$query%' OR lastname LIKE '%$query%' OR email LIKE '%$query'");
        if ($users != "false") {
            $fields = $users[1]['con'][0];
            for ($i = 0; $i < count($users[0]); $i++) {
                $field = 0;
                while ($field <= $fields - 1) {
                    $result .= $users[0][$i][$field];
                    if ($field != $fields - 1) {
                        $result .= ',';
                    }
                    $field++;
                }
                if ($i != count($users[0]) - 1) {
                    $result .= '\n';
                }
            }
            echo $result;
            exit;
        } else {
            echo '';
            exit;
        }
    }
    
    function createGroup($name, $userIds) {
		global $header;
		global $session;
        global $db;

        $userIdArray = explode(',', $userIds);

        // Create a group and get the id of it
        $groupId = $db->createGroup($name);

        // Add users to the group
        foreach ($userIdArray as $userId) {
            if (isset($userId)) {
                $db->addUserToGroup($groupId, $userId);
            }
        }

        // If the current user is not in the list, add the user too
        if (!in_array($session->getData("UserId"), $userIdArray)) {
            $db->addUserToGroup($groupId, $session->getData("UserId"));
        }

        // Reload the page
        $header->setHeader("mHome");
    }

    function loadGroups() {
        global $db;
        global $session;

        $result = [];

        $userId = $session->getData('UserId');

        $groups = $db->single_dynamic_query("SELECT groupchat.id, groupchat.name FROM groupchat INNER JOIN user_group ON groupchat.id = user_group.group_id WHERE user_group.user_id = $userId");

        if ($groups != 'false') {
            foreach ($groups[0] as $group) {
                array_push($result, array('id' => $group[0], 'name' => $group[1]));
            }
        }

        echo json_encode($result);
        exit;
    }

    function openGroup($groupId) {
        global $session;
        $session->putData("GroupId", $groupId);
        exit;
    }

    function sendMessage($message, $mentions) {
        global $session;
        global $db;

        $userId = $session->getData('UserId');
        $groupId = $session->getData('GroupId');

        if (isset($groupId) && isset($userId)) {
            $messageId = $db->sendMessage($groupId, $userId, $message);

            if ($mentions != '') {
                $sender = $db->single_dynamic_query("SELECT firstname, lastname FROM user WHERE id = $userId");
                if ($sender != 'false') {
                    $senderFullName = $sender[0][0][0] . ' ' . $sender[0][0][1];
                    $message = $senderFullName . ' has mentioned you.';
                    foreach ($mentions as $receiverId) {
                        $db->createNotification($receiverId, $message, $messageId);
                    }
                }
            }

            echo $messageId;
            exit;
        }
    }

    function loadMessages($after) {
        $response = '';

        global $session;
        global $db;
        
        // TODO: Security - Check if user is in the group

        $groupId = $session->getData("GroupId");
        $userId = $session->getData("UserId");

        if (isset($groupId) && isset($userId)) {
            $resultArray = [];
            
            if ($after != '') {                
                $messages = $db->single_dynamic_query("SELECT message.id, message.date, user.id, user.firstname, user.lastname, message.deleted_date, message.edited_date, message.pinned_date, message.read_date FROM message INNER JOIN user ON message.user_id = user.id WHERE groupchat_id = '$groupId' AND message.id > $after ORDER BY message.id");
            } else {
                $messages = $db->single_dynamic_query("SELECT message.id, message.date, user.id, user.firstname, user.lastname, message.deleted_date, message.edited_date, message.pinned_date, message.read_date FROM message INNER JOIN user ON message.user_id = user.id WHERE groupchat_id = '$groupId' ORDER BY message.id");
            }

            if ($messages != "false") {
                foreach ($messages[0] as $message) {
                    $messageId = $message[0];

                    $type = '';
                    $data = '';

                    $textMessage = $db->single_dynamic_query("SELECT data FROM message_text WHERE id = '$messageId'");

                    if ($textMessage != "false") {
                        $type = "text";
                        $data = $textMessage[0][0][0];
                    }
                    
                    $imageMessage = $db->single_dynamic_query("SELECT id FROM message_image WHERE id = '$messageId'");
                    if ($imageMessage != "false") {
                        $type = "image";
                    }
                    
                    $videoMessage = $db->single_dynamic_query("SELECT id FROM message_video WHERE id = '$messageId'");
                    if ($videoMessage != "false") {
                        $type = "video";
                    }

                    $pollMessage = $db->single_dynamic_query("SELECT title, due, multi_select, ended_date FROM message_poll WHERE id = '$messageId'");

                    if ($pollMessage != "false") {

                        $options = $db->single_dynamic_query("SELECT id, name FROM poll_option WHERE message_poll_id = '$messageId'");
                        
                        $optionArray = [];

                        if ($options != "false") {
                            foreach ($options[0] as $option) {
                                array_push($optionArray, array('id' => $option[0], 'name' => $option[1]));
                            }
                        }

                        $voted = $db->single_dynamic_query("SELECT * FROM vote INNER JOIN poll_option ON vote.poll_option_id = poll_option.id WHERE user_id = '$userId' AND message_poll_id = '$messageId'") != "false";

                        // TODO: This can be combined with optionArray
                        $result = [];
                        if ($pollMessage[0][0][3] != '') {
                            if ($options != "false") {
                                foreach ($options[0] as $option) {
                                    $votes = $db->single_dynamic_query("SELECT * FROM vote WHERE poll_option_id = '$option[0]'");
                                    if ($votes != "false") {
                                        array_push($result, array('id' => $option[0], 'name' => $option[1], 'count' => count($votes[0])));
                                    } else {
                                        array_push($result, array('id' => $option[0], 'name' => $option[1], 'count' => 0));
                                    }
                                }
                            }
                        }

                        $type = "poll";
                        $data = array('title' => $pollMessage[0][0][0], 'due' => $pollMessage[0][0][1], 'multiselect' => $pollMessage[0][0][2], 'options' => $optionArray, 'voted' => $voted, 'endedDate' => $pollMessage[0][0][3], 'result' => $result);
                    }

                    $isMine = $message[2] == $userId;

                    array_push($resultArray, array('messageId' => $messageId, 'date' => $message[1], 'isMine' => $isMine, 'userFirstName' => $message[3], 'userLastName' => $message[4], 'type' => $type, 'data' => $data, 'deletedDate' => $message[5], 'editedDate' => $message[6], 'pinnedDate' => $message[7], 'readDate' => $message[8]));
                }
                $response = json_encode($resultArray);
            }
        }

        echo $response;
        exit;
    }

    function getUpdatedMessages($updatedLaterThan) {
        $response = "false";

        global $session;
        global $db;

        $userId = $session->getData("UserId");
        $groupId = $session->getData("GroupId");
        
        $this->updateMessagesToRead($userId, $groupId);
        $this->updatePollToEnded($groupId);

        $editedMessages = $db->single_dynamic_query("SELECT id FROM message WHERE edited_date >= '$updatedLaterThan' AND groupchat_id = '$groupId'");
        $pinnedMessages = $db->single_dynamic_query("SELECT id FROM message WHERE pinned_date >= '$updatedLaterThan' AND groupchat_id = '$groupId'");
        $deletedMessages = $db->single_dynamic_query("SELECT id FROM message WHERE deleted_date >= '$updatedLaterThan' AND groupchat_id = '$groupId'");
        $endedPolls = $db->single_dynamic_query("SELECT id FROM message_poll INNER JOIN message ON message_poll.id = message.id WHERE message_poll.ended_date >= '$updatedLaterThan' AND message.groupchat_id = '$groupId'");

        if ($editedMessages != "false" || $pinnedMessages != "false" || $deletedMessages != "false" || $endedPolls != "false") {
            $response = "true";
        }
        
        echo $response;
        exit;
    }

    function loadNotifications() {
        global $session;
        global $db;
        
        $userId = $session->getData("UserId");


        if (isset($userId)) {
            $messages = $db->single_dynamic_query('SELECT message, date, is_read, message_id  FROM notification WHERE user_id ='.$userId);

            //$messages = $db->single_dynamic_query("SELECT user.id, user.firstname, user.lastname, message.date, message.id, message_text.data FROM message INNER JOIN user ON message.user_id = user.id INNER JOIN message_text ON message.id = message_text.id WHERE groupchat_id = '$groupId' ORDER BY message.date");
            if ($messages != "false") {
                $result = '';

                for ($i = 0; $i < count($messages[0]); $i++) {
                    for ($j = 0; $j < count($messages[0][$i]); $j++) {

                        $result .= $messages[0][$i][$j];
                        
                        if ($j != count($messages[0][$i]) - 1) {
                            $result .= ',';
                        }
                    }
                    if ($i != count($messages[0]) - 1) {
                        $result .= '\n';
                    }
                }
                echo $result;
            } else {
                echo "";
            }
            exit;
        }
    }

    function updateNotificationsToRead()
    {
        global $session;
        global $db;
        
        $userId = $session->getData("UserId");
        $db->updateNotificationsIsReadToRead($userId);
    }

    function createPoll($data) {
        global $db;
        global $session;

        $groupId = $session->getData("GroupId");
        $userId = $session->getData("UserId");

        $options = [];

        // Get PHP data from json
        foreach (json_decode($data, true) as $field) {
            switch ($field["name"]) {
                case "title":
                    $title = $field["value"];
                break;
                case "option":
                    array_push($options, $field["value"]);
                break;
                case "dueDate":
                    $date = $field["value"];
                break;
                case "dueTime":
                    $time = $field["value"];
                break;
                case "multiselect":
                    if ($field["value"] == "on") {
                        $multiSelect = "true";
                    }
                break;
            }
        }

        if (!isset($multiSelect)) {
            $multiSelect = "false";
        }
        
        // Adjust date and time
        if ($date == '' && $time == '') {
            $datetime = 'null';
        } else if ($date != '' && $time == '') {
            $datetime = "'" . $date . ' ' . "00:00:00" . "'";
        } else if ($date == '' && $time != '') {
            $datetime = "'" . date("Y-m-d") . ' ' . $time . ":00" . "'";
        } else {
            $datetime = "'" . $date . ' ' . $time . ":00" . "'";
        }

        // Save poll and get the id of the new poll
        $pollId = $db->createPoll($groupId, $userId, $title, $datetime, $multiSelect);

        // Add option to the poll
        foreach ($options as $option) {
            $db->addOptionToPoll($pollId, $option);
        }

        echo '';
        exit;
    }

    function vote($data) {
        global $db;
        global $session;
        
        $userId = $session->getData("UserId");

        // TODO: Security - Check if the option belongs to the poll
        // TODO: Security - Check if multiselect is enabled when there are more options

        try {    
            foreach (json_decode($data, true) as $option) {
                $db->vote($userId, $option["value"]);
            }
            echo "true";
        } catch (Exception $e) {
            echo "false";
        }
        exit;
    }

    function endPoll($messageId, $force) {
        $response = '';

        global $db;
        global $session;

        $userId = $session->getData("UserId");

        // Check if the current user created the poll
        $poll = $db->single_dynamic_query("SELECT ended_date FROM message_poll INNER JOIN message ON message_poll.id = message.id WHERE message.id = '$messageId' AND user_id = '$userId'");

        if ($poll != "false") {
            // Check if the poll already ended
            if ($poll[0][0][0] == '') {
                // Check if all users participated
                $allUsersInPoll = $db->single_dynamic_query("SELECT user_group.user_id FROM message INNER JOIN user_group ON message.groupchat_id = user_group.group_id WHERE message.id = '$messageId'");
                $participants = $db->single_dynamic_query("SELECT DISTINCT vote.user_id FROM vote INNER JOIN poll_option ON vote.poll_option_id = poll_option.id INNER JOIN message ON poll_option.message_poll_id = message.id WHERE message.id = '$messageId'");

                if ($participants == "false" && $force != "true") {
                    $response = "false";
                } else {
                    if ($participants == "false" || count($allUsersInPoll[0]) == count($participants[0])) {
                        // End poll
                        $db->endPoll($messageId);
                        $response = "true";
                    } else {
                        // End poll after asking user once again. 
                        if ($force == "true") {
                            $db->endPoll($messageId);
                            $response = "true";
                        } else {
                            $response = "false";
                        }
                    }
                }
            } else {
                $response = "Poll is already ended.";
            }
        }

        echo $response;
        exit;
    }

    function updatePollToEnded($groupId) {
        global $db;
        try {
            $db->endPassedPolls($groupId);
        } catch (Exception $e) {
            // TODO: Log the error
        }
    }

    function deleteMessage($messageId) {
        global $db;

        try {    
            $db->deleteMessage($messageId);
            echo "true";
        } catch (Exception $e) {
            echo "false";
        }
        exit;
    }

    function editMessage($data) {
        global $db;

        try {    
            // Get PHP data from json
            foreach (json_decode($data, true) as $field) {
                switch ($field["name"]) {
                    case "messageId":
                        $messageId = $field["value"];
                    break;
                    case "data":
                        $message = $field["value"];
                    break;
                }
            }
            $db->editMessage($messageId, $message);
            echo "true";
        } catch (Exception $e) {
            echo "false";
        }
        exit;
    }

    function updateMessagesToRead($userId, $groupId)
    {
        global $db;
        $db->updateMessagesToRead($userId, $groupId);
    }

    function pinMessage($messageId) {
        global $db;
        global $session;

        $groupId = $session->getData("GroupId");

        try {    
            $db->pinMessage($messageId, $groupId);
            echo "true";
        } catch (Exception $e) {
            echo "false";
        }
        exit;
    }

    function sendImage($file) {
        global $db;
        global $session;
        
        $response = "false";
        
        $userId = $session->getData("UserId");
        $groupId = $session->getData("GroupId");

        $folderName = PATH_UPLOAD;
        $fileName = basename($file["name"]);

        $isImage = getimagesize($file["tmp_name"]);

        // TODO: Make every image file unique (e.g. with message Id)

        if ($isImage) {
            $messageId = $db->sendImage($groupId, $userId, $folderName, $fileName);

            if (move_uploaded_file($file["tmp_name"], $folderName . $messageId . '.' . $fileName)) {
                $response = "true";
            } else {
                // TODO: Delete message
            }
        }

        echo $response;
        exit;
    }

    function loadImage($messageId) {
        global $db;
        $response = "false";
        $imageMessage = $db->single_dynamic_query("SELECT path FROM message_image WHERE id = '$messageId'");
        if ($imageMessage != "false") {
            $response = $imageMessage[0][0][0];
        }
        echo $response;
        exit;
    }

    function sendVideo($file) {
        global $db;
        global $session;
        
        $response = "false";
        
        $userId = $session->getData("UserId");
        $groupId = $session->getData("GroupId");

        $folderName = PATH_UPLOAD;
        $fileName = basename($file["name"]);

        $mime = mime_content_type($file["tmp_name"]);
        $isVideo = strstr($mime, "video/");

        // TODO: Make every image file unique (e.g. with message Id)

        if ($isVideo) {
            $messageId = $db->sendVideo($groupId, $userId, $folderName, $fileName);

            if (move_uploaded_file($file["tmp_name"], $folderName . $messageId . '.' . $fileName)) {
                $response = "true";
            } else {
                // TODO: Delete message
            }
        }

        echo $response;
        exit;
    }

    function loadVideo($messageId) {
        global $db;
        $response = "false";
        $imageMessage = $db->single_dynamic_query("SELECT path FROM message_video WHERE id = '$messageId'");
        if ($imageMessage != "false") {
            $response = $imageMessage[0][0][0];
        }
        echo $response;
        exit;
    }

    /**
     * 
     * @param string $query 
     * @return
     */
    function queryUserFromCurrentGroup($query) {
        global $db;  
        global $session;

        $groupId = $session->getData("GroupId");

        $result = '';      
        $users = $db->single_dynamic_query("SELECT user.id, user.firstname, user.lastname, user.email FROM user_group inner join user on user_group.user_id = user.id WHERE user_group.group_id = $groupId AND (user.firstname LIKE '%$query%' OR user.lastname LIKE '%$query%' OR user.email LIKE '%$query')");
        if ($users != "false") {
            $fields = $users[1]['con'][0];
            for ($i = 0; $i < count($users[0]); $i++) {
                $field = 0;
                while ($field <= $fields - 1) {
                    $result .= $users[0][$i][$field];
                    if ($field != $fields - 1) {
                        $result .= ',';
                    }
                    $field++;
                }
                if ($i != count($users[0]) - 1) {
                    $result .= '\n';
                }
            }
            echo $result;
            exit;
        } else {
            echo '';
            exit;
        }
    }
}

$actionObj = new Action($_REQUEST['action']);
?>