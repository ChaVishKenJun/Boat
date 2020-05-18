<?php
class Action {
    var $action;
    
    // Constructor
    function Action($action) {
        global $security;
        
        switch ($action) {
            case "aCreateOrEditClient":
                $this->CreateOrEditClient($_POST['personId'], $_POST['firstname'], $_POST['lastname'], $_POST['mobilenumber']);
            break;
            case "aCreateOrEditItem":
                $this->CreateOrEditItem($_POST['itemId'], $_POST['title'], $_POST['type'], $_POST['firstname'], $_POST['lastname'], $_POST['category']);
            break;
            case "aBorrowItem":
                $this->BorrowItem($_POST['title'], $_POST['dateFrom'], $_POST['dateTo'], $_POST['firstName'], $_POST['lastName']);
            break;
            case "aReturnItem":
                $this->ReturnItem($_POST['title'], $_POST['type'], $_POST['firstName'], $_POST['lastName']);
            break;
            case "aReserveItem";
			    $this->ReserveItem($_POST['title'], $_POST['dateFrom'], $_POST['dateTo'], $_POST['firstName'], $_POST['lastName']);
            break;
            case "aEditClient":
                if ($_GET['PersonId']) {
                    $this->EditClient($_GET['PersonId']);
                }
            break;
            case "aEditItem":
                if ($_GET['ItemId']) {
                    $this->EditItem($_GET['ItemId']);
                }
            break;
            case "aDeleteItem":
                if ($_GET['ItemId']) {
                    $this->DeleteItem($_GET['ItemId']);
                }
            break;
            case "aDeleteClient":
                if ($_GET['PersonId']) {
                    $this->DeleteClient($_GET['PersonId']);
                }
            break;
            case "aCreateGroup":                
                $this->createGroup($_POST['name'], $_POST["users"]);
            break;
            case "aSignUp":
                if ($security->dataintegrity($_REQUEST) == 1) {
                    $this->signUp($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
                } else {
                    echo "XSS Attack";
                    exit;
                }
            break;
            case "aSignIn":
                if ($security->dataintegrity($_REQUEST) == 1) {
                    $this->signIn($_POST['email'], $_POST['password']);	
                } else {
                    echo "XSS Attack";
                    exit;
                }
            break;
            case "aSignOut":
                if ($security->dataintegrity($_REQUEST) == 1) {
                    $this->signOut();
                } else {
                    echo "XSS Attack";
                    exit;
                }  
            break;
            case "aQueryUser":
                $this->queryUser($_GET["query"]);
            break;
            case "aOpenGroup":
                $this->openGroup($_GET["groupId"]);
            break;
            case "aSendMessage":
                $this->sendMessage($_GET["message"]);
            break;
            case "aLoadMessages":
                $this->loadMessages();
            break;
        }
    }
    
    function CreateOrEditClient($clientId,$firstname,$lastname,$mobilenumber) {
            //global
            global $session; 
            global $header;
            global $security;
            global $db;
            $role = "Client";
            //validation
            $session->unsetDataCreateOrEditClientValidation();
            $session->PutData('cPersonIdValue', $clientId);
            $session->PutData('cFirstNameValue', $firstname);
            $session->PutData('cLastNameValue', $lastname);
            $session->PutData('cMobileNumberValue', $mobilenumber);
            
            if($firstname == null)
            {
                $session->PutData('cFirstName',0);
                $session->PutData('cfirstNameEmpty',0);
                $session->PutData('validation', 0);
            } else {
                $session->PutData('cFirstName',1);
            }
            if($lastname == null)
            {
                $session->PutData('cLastName',0);
                $session->PutData('clastNameEmpty',0);
                $session->PutData('validation', 0);
            } else {
                $session->PutData('cLastName',1);
            }
            if($mobilenumber == null)
            {
                $session->PutData('cMobileNumber',0);
                $session->PutData('cMobileNumberEmpty',0);
                $session->PutData('validation', 0);
            } else {
                $session->PutData('cMobileNumber',1);
            }
            if($session->getData('cMobileNumber')==1)
            {
                if($security->plausibilitycheck($mobilenumber,3)!=1)
                {
                    $session->PutData('cMobileNumber',0);
                    $session->PutData('cMobileNumberString',0);
                    $session->PutData('validation', 0);
                } else {
                    $session->PutData('cMobileNumber',1);
                    $session->PutData('cMobileNumberString',1);
                }
            }
            
            //check if item exists
            if($session->getData('cFirstName')==1 AND $session->getData('cLastName')==1 AND $session->getData('cMobileNumber')==1)
            {
                $ifclientexists = $db->singlequery_dynamic("SELECT PersonId from person WHERE firstname='$firstname' AND lastname ='$lastname' AND mobilenumber='$mobilenumber'");
            }
            else
            {
		$header->Header('mcreateOrEditClient');
            }
            //sql //go back
            if($ifclientexists=="true") {
                $session->PutData('cClientExists',0);
                $session->PutData('validation', 0);
                $header->Header('mcreateOrEditClient');  
		} else {
                    //user not found
                        $session->unsetDataCreateOrEditClient();
                            if($clientId != null)
                            {
                                $db->singlequery_dynamic("UPDATE person SET FirstName='$firstname', LastName='$lastname', MobileNumber=$mobilenumber WHERE PersonId = $clientId");
                            }
                            else{
                                $db->singlequery_dynamic("INSERT INTO person (FirstName, LastName, MobileNumber, Role)"
                            . "VALUES ('$firstname', '$lastname', '$mobilenumber', '$role')");
                            }
                        
                        
			$header->Header('mClients');
		}
	}
        
        
	function CreateOrEditItem($itemId,$title, $type, $firstname ,$lastname,$category) {

            //global
            global $session; 
            global $header;
            global $security;
            global $db;
            $typevalue;
            $role;
            $session->unsetDataCreateOrEditItemValidation();
            $session->PutData('iTitleValue', $title);
            $session->PutData('iTypeValue', $type);
            $session->PutData('iFirstNameValue', $firstname);
            $session->PutData('iLastNameValue', $lastname);
            $session->PutData('iCategoryValue', $category);
            
            //validation
            if($firstname == null)
            {
                $session->PutData('iFirstName',0);
                $session->PutData('iFirstNameEmpty',0);
            } else {
                $session->PutData('iFirstName',1);
            }
            if($lastname == null)
            {
                $session->PutData('iLastName',0);
                $session->PutData('iLastNameEmpty',0);
            } else {
                $session->PutData('iLastName',1);
            }
            if($title == null)
            {
                $session->PutData('iTitle',0);
                $session->PutData('iTitleEmpty',0);
            } else {
                $session->PutData('iTitle',1);
            }
            if($category == null)
            {
                $session->PutData('iCategory',0);
                $session->PutData('iCategoryEmpty',0);
            } else {
                $session->PutData('iCategory',1);
            }
            if($type == null)
            {
                $session->PutData('iType',0);
                $session->PutData('iTypeEmpty',0);
            } else {
                $session->PutData('iType',1);
            }
//            if($security->plausibilitycheck($type,2)!=1)
//            {
//                $session->PutData('rType',0);
//            } else {
//                $session->PutData('rType',1);
//            }
            //check if item exists
            if($session->getData('iFirstName')==1 AND $session->getData('iLastName')==1 AND $session->getData('iTitle')==1 AND $session->getData('iCategory')==1 AND $session->getData('iType')==1)
            {
                    if($type == 0)
                    {
                        $typevalue = "Book";
                        $role = "Author";
                    }
                    else{ $typevalue = "Video"; $role = "Director"; }
                $ifitemexists = $db->singlequery_dynamic("SELECT itemId from item WHERE title='$title' AND type ='$typevalue'");
               
            }
            else
            {
		$header->Header('mcreateOrEditItem');
            }
            //sql //go back
            if($ifitemexists=="true") {
                $session->PutData('iItemExists',0);
                $header->Header('mcreateOrEditItem');  
		} else {
                    //user not found
                    $session->unsetDataCreateOrEditItem();
                    
                    $ifpersonexists = $db->singlequery_dynamic("SELECT personId from person WHERE FirstName='$firstname' AND LastName='$lastname'");
                    if($ifpersonexists == "false")
                    {
                        $db->singlequery_dynamic("INSERT INTO person (FirstName, LastName, MobileNumber, Role)"
                            . "VALUES ('$firstname', '$lastname', 'null', '$role')");
                    }
                    $personId = $db->getid_person($firstname, $lastname);
                    if($itemId != null)
                    {
                        $db->singlequery_dynamic("UPDATE item SET Title='$title', Type='$type', PersonId=$personId, ItemCategoryId=$category WHERE ItemId = $itemId");
                    }
                    else
                    {
                        $db->singlequery_dynamic("INSERT INTO item (ItemCategoryId, PersonId, Title, Type)"
                            . "VALUES ('$category', '$personId', '$title', '$typevalue')");
                    }
                    
                
			$header->Header('mItems');
		}
	}
	function BorrowItem($title,$dateFrom,$dateTo,$firstName,$lastName) {
            //global
            global $session; 
            global $header;
            global $security;
            global $db;
            //validation
            $session->PutData('bTitleValue', $title);
            $session->PutData('bDateFromValue', $dateFrom);
            $session->PutData('bDateToValue', $dateTo);
            $session->PutData('bFirstNameValue', $firstName);
            $session->PutData('bLastNameValue', $lastName);
            if($title == null)
            {
                
                $session->PutData('bTitle',0);
                $session->PutData('bTitleEmpty',0);
            } else {
                $session->PutData('bTitle',1);
            }
            if($dateFrom == null)
            {
                
                $session->PutData('bDateFrom',0);
                $session->PutData('bDateFromEmpty',0);
            } else {
                $session->PutData('bDateFrom',1);
            }
            if($dateTo == null)
            {
                $session->PutData('bDateTo',0);
                $session->PutData('bDateToEmpty',0);
            } else {
                $session->PutData('bDateTo',1);
            }
            if($session->getData('bDateFrom')==1)
            {
                if($security->validateDate($dateFrom) != 1)
                {
                $session->PutData('bDateFrom',0);
                $session->PutData('bDateFromWrongValue',0);
            }
            }
            if($session->getData('bDateTo')==1)
            {
                if($security->validateDate($dateTo) != 1)
                {
                $session->PutData('bDateTo',0);
                $session->PutData('bDateToWrongValue',0);
            }
            }
            if($firstName == null)
            {
                $session->PutData('bFirstName',0);
                $session->PutData('bFirstNameEmpty',0);
            } else {
                $session->PutData('bFirstName',1);
            }
            if($lastName == null)
            {
                $session->PutData('bLastName',0);
                $session->PutData('bLastNameEmpty',0);
            } else {
                $session->PutData('bLastName',1);
            }
            $dateF  = explode('.', $dateFrom);
            $dateFrom = $dateF[2]."-".$dateF[1]."-".$dateF[0];
            $dateT  = explode('.', $dateTo);
            $dateTo = $dateT[2]."-".$dateT[1]."-".$dateT[0];  
            if($dateFrom > $dateTo)
            {exit;
                $session->PutData('bDate',0);
                $session->PutData('bDateBigger',0);
            } else {
                $session->PutData('bDate',1);
            }
            //check if item and client exists
            if($session->getData('bTitle')==1 AND $session->getData('bDateFrom')==1 AND $session->getData('bDateTo')==1 AND $session->getData('bFirstName')==1 AND $session->getData('bLastName')==1 AND $session->getData('bDate')==1)
            {
                $ifclientexists = $db->singlequery_dynamic("SELECT PersonId from person WHERE firstname='$firstName' AND lastname ='$lastName'");
                $ifitemexists = $db->singlequery_dynamic("SELECT ItemId from item WHERE title='$title'");
                $itemId = $db->getid_item($title);
                
                
                
                $ifiteminotsavailable = $db->singlequery_dynamic("SELECT * FROM activityhistory WHERE ItemId =$itemId AND ((Activity = 'Borrow' AND DateTo > $dateFrom) OR (Activity = 'Reserve' AND (($dateFrom > DateFrom AND $dateFrom< DateTo) OR ($dateFrom > DateFrom AND $dateTo < DateTo) OR ($dateTo > DateFrom AND $dateTo < DateTo))))");
            }
            else
            {
		$header->Header('mborrowItem');
            }
            //sql //go back AND $ifitemisavailable == "true"
            if($ifclientexists == "false" || $ifitemexists == "false" || $ifiteminotsavailable == "true") {
                    if($ifclientexists=="false")
                    {
                        $session->PutData('bClientNotExist',0);
                    }
                    if($ifitemexists=="false")
                    {
                        $session->PutData('bItemNotExist',0);
                   }
                    if($ifiteminotsavailable=="true")
                    {
                        $session->PutData('bItemNotAvailable',0);
                    }
                    $header->Header('mborrowItem'); 
		} else {
                    $activity = 'Borrow';
                $itemId = $db->getid_item($title);
                $personId  = $db->getid_person($firstName, $lastName);
                $session->unsetDataBorrowItemValidation();
                $session->unsetDataBorrowBook();    
                $db->singlequery_dynamic("INSERT INTO activityhistory (ItemId, PersonId, Activity, DateFrom, DateTo)"
                    . "VALUES ('$itemId','$personId', '$activity', '$dateFrom', '$dateTo')");
                
                $header->Header('mItems');  
		}
	}
        function EditItem($ItemId)
        {
            global $session;
            global $db;
            global $header;
            $result = $db->getItemData($ItemId);
            $row = $result->fetch_assoc();
            $session->putData('iItemIdValue', $ItemId);
            $session->PutData('iTitleValue', $row["Title"]);
            if($row["Type"] == "Book")
            {
                $session->PutData('iTypeValue', 0);
            }else{
                $session->PutData('iTypeValue', 1);
            }
            
            $session->PutData('iFirstNameValue', $row["FirstName"]);
            $session->PutData('iLastNameValue', $row["LastName"]);
            $session->PutData('iCategoryValue', $row["ItemCategoryId"]);
            $header->Header('mcreateOrEditItem'); 
            
        }
        function DeleteItem($itemId)
        {
            global $db;
            global $header;
            $db->deleteItem($itemId);
            $header->Header('mItems'); 
            
        }
        function DeleteClient($clientId)
        {
            global $db;
            global $header;
            
            $db->deleteClient($clientId); 
            $header->Header('mClients'); 
        }
        function EditClient($ClientId)
        {
            global $session;
            global $db;
            global $header;
            $result = $db->getClientData($ClientId);
            $row = $result->fetch_assoc();
            $session->putData('cPersonIdValue', $ClientId);
            $session->PutData('cFirstNameValue', $row["FirstName"]);
            $session->PutData('cLastNameValue', $row["LastName"]);
            $session->PutData('cMobileNumberValue', $row["MobileNumber"]);
            $header->Header('mcreateOrEditClient'); 
            
        }
        function ReturnItem($title,$type,$firstName,$lastName) {
            //global
            global $session; 
            global $header;
            global $db;
            //validation
            $session->unsetDataReturnItemValidation();
            $session->PutData('reTitleValue', $title);
            $session->PutData('reTypeValue', $type);
            $session->PutData('reFirstNameValue', $firstName);
            $session->PutData('reLastNameValue', $lastName);
            if($title == null)
            {
                $session->PutData('reTitle',0);
                $session->PutData('reTitleEmpty',0);
            } else {
                $session->PutData('reTitle',1);
            }
            
            if($type == null)
            {
                $session->PutData('reType',0);
                $session->PutData('reTypeEmpty',0);
            } else {
                $session->PutData('reType',1);
            }
            if($firstName == null)
            {
                $session->PutData('reFirstName',0);
                $session->PutData('reFirstNameEmpty',0);
            } else {
                $session->PutData('reFirstName',1);
            }
            if($lastName == null)
            {
                $session->PutData('reLastName',0);
                $session->PutData('reLastNameEmpty',0);
            } else {
                $session->PutData('reLastName',1);
            }
            
            //check if item and client exists
            if($session->getData('reTitle')==1 AND $session->getData('reType')==1 AND $session->getData('reFirstName')==1 AND $session->getData('reLastName')==1)
            {
                $ifclientexists = $db->singlequery_dynamic("SELECT PersonId from person WHERE firstname='$firstName' AND lastname ='$lastName'");
                $ifitemexists = $db->singlequery_dynamic("SELECT ItemId from item WHERE title='$title' AND type='$type'");
            
                
            }
            else
            {
		$header->Header('mreturnItem');
            }
            //sql //go back 
            if($ifclientexists == "false" AND $ifitemexists == "false") {
                exit;
                    if($ifclientexists==false)
                    {
                        $session->PutData('reClientNotExist',0);
                    }
                    if($ifitemexists==false)
                    {
                        $session->PutData('reItemNotExist',0);
                   }
                    $header->Header('mreturnItem'); 
		} else {
                   $activity = 'Return';
                $itemId = $db->getid_item($title);
                $personId  = $db->getid_person($firstName, $lastName);
                $dateReturned = date("Y-m-d");
                $session->unsetDataBorrowItemValidation();
                $session->unsetDataBorrowBook();
                    
                $db->singlequery_dynamic("INSERT INTO activityhistory (ItemId, PersonId, Activity, DateReturned)"
                    . "VALUES ('$itemId','$personId', '$activity', '$dateReturned')");
                
                $header->Header('mItems');  
		}
	}
        
        function ReserveItem($title,$dateFrom,$dateTo,$firstName,$lastName) {
            //global
            global $session; 
            global $header;
            global $security;
            global $db;
            //validation
            $session->unsetDataReserveItemValidation();
            $session->PutData('reTitleValue', $title);
            $session->PutData('reDateFromValue', $dateFrom);
            $session->PutData('reDateToValue', $dateTo);
            $session->PutData('reFirstNameValue', $firstName);
            $session->PutData('reLastNameValue', $lastName);
            if($title == null)
            {
                $session->PutData('reTitle',0);
                $session->PutData('reTitleEmpty',0);
            } else {
                $session->PutData('reTitle',1);
            }
            if($dateFrom == null)
            {
                $session->PutData('reDateFrom',0);
                $session->PutData('reDateFromEmpty',0);
            } else {
                $session->PutData('reDateFrom',1);
            }
            if($dateTo == null)
            {
                $session->PutData('reDateTo',0);
                $session->PutData('reDateToEmpty',0);
            } else {
                $session->PutData('reDateTo',1);
            }
            if($session->getData('reDateFrom')==1)
            {
                if($security->validateDate($dateFrom) != 1)
                {
                $session->PutData('reDateFrom',0);
                $session->PutData('reDateFromWrongValue',0);
            }
            }
            if($session->getData('reDateTo')==1)
            {
                if($security->validateDate($dateFrom) != 1)
                {
                $session->PutData('reDateTo',0);
                $session->PutData('reDateToWrongValue',0);
            }
            }
            if($firstName == null)
            {
                $session->PutData('reFirstName',0);
                $session->PutData('reFirstNameEmpty',0);
            } else {
                $session->PutData('reFirstName',1);
            }
            if($lastName == null)
            {
                $session->PutData('reLastName',0);
                $session->PutData('reLastNameEmpty',0);
            } else {
                $session->PutData('reLastName',1);
            }
            
                $dateF  = explode('.', $dateFrom);
                $dateFrom = $dateF[2]."-".$dateF[1]."-".$dateF[0];
                $dateT  = explode('.', $dateTo);
                $dateTo = $dateT[2]."-".$dateT[1]."-".$dateT[0];  
            if($dateFrom > $dateTo)
            {
                $session->PutData('reDate',0);
                $session->PutData('reDateBigger',0);
            } else {
                $session->PutData('reDate',1);
            }
            
            //check if item and client exists
            if($session->getData('reTitle')==1 AND $session->getData('reDateFrom')==1 AND $session->getData('reDateTo')==1 AND $session->getData('reFirstName')==1 AND $session->getData('reLastName')==1 AND $session->getData('reDate')==1)
            {
                $ifclientexists = $db->singlequery_dynamic("SELECT PersonId from person WHERE firstname='$firstName' AND lastname ='$lastName'");
                $ifitemexists = $db->singlequery_dynamic("SELECT ItemId from item WHERE title='$title'");
                
                $itemId = $db->getid_item($title);
                
                $ifiteminotsavailable = $db->singlequery_dynamic("SELECT * FROM activityhistory WHERE ItemId =$itemId AND ((Activity = 'Borrow' AND DateTo > $dateFrom) OR (Activity = 'Reserve' AND (($dateFrom > DateFrom AND $dateFrom< DateTo) OR ($dateFrom > DateFrom AND $dateTo < DateTo) OR ($dateTo > DateFrom AND $dateTo < DateTo))))");
                
            }
            else
            {
		$header->Header('mreserveItem');
            }
            //sql //go back AND $ifitemisavailable == "true"
            if($ifclientexists == "false" || $ifitemexists == "false" || $ifiteminotsavailable == "true") {
                    if($ifclientexists=="false")
                    {
                        $session->PutData('reClientNotExist',0);
                    }
                    if($ifitemexists=="false")
                    {
                        $session->PutData('reItemNotExist',0);
                   }
                    if($ifiteminotsavailable=="true")
                    {
                        $session->PutData('reItemNotAvailable',0);
                    }
                    $header->Header('mreserveItem'); 
		} else {
                    $activity = 'Reserve';
                $itemId = $db->getid_item($title);
                $personId  = $db->getid_person($firstName, $lastName);
                $session->unsetDataReserveItemValidation();
                $session->unsetDataReserveItem();
                
                $db->singlequery_dynamic("INSERT INTO activityhistory (ItemId, PersonId, Activity, DateFrom, DateTo)"
                    . "VALUES ('$itemId','$personId', '$activity', '$dateFrom', '$dateTo')");
                
                $header->Header('mItems');  
		}
        }
    
	function signIn($email, $password) {
		global $header;
		global $security;
		global $session;
        global $db;
        
        $encryptet_pw = md5($password);

        $isFound = $db->single_dynamic_query("SELECT id FROM user WHERE email='$email' AND password='$encryptet_pw'");

        if ($isFound == "false") {
            $session->putData("SignInAttemptMessage", 1);
            $session->putData("SignedIn", "false");
            $header->setHeader("mSignIn");
        } else {
            $session->unsetData("SignInAttemptMessage");
            $session->putData("SignedIn", "true");
            $session->putData("UserId", $isFound[0][0][0]);
            $header->setHeader("mHome");
        }
	}

	function signOut() {
		global $session; 
        global $header;

		$session->putData("SignInMessage", "You are succesfully  out.");
        
        $session->putData("SignedIn", "false");
        $session->unsetData("UserId");
		$header->setHeader("mSignIn");
    }
    
    function signUp($firstname, $lastname, $email, $password) {	
		//Globalize
		global $header;
		global $security;
		global $session;
		global $db;
                
		$encryptet_pw = md5($password); 
                
		$iffound = $db->single_dynamic_query("SELECT id from user WHERE email='$email'");

        //check if item exists
		if($iffound=='false') {
            //user not found
            $session->unsetData('useralreadyexistmessage');
            $db->single_dynamic_query("INSERT INTO user (firstname, lastname, email, password)"
            . "VALUES ('$firstname', '$lastname', '$email', '$encryptet_pw')");
            $session->putData("SignInMessage", "You are successfully signed up.") ;
            $header->setHeader('mSignIn');
		} else { 
            $session->PutData('useralreadyexistmessage', 1);
            $header->setHeader('mSignUp');
        }

    }

    /**
     * 
     * @param string $query 
     * @return
     */
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
        foreach ($userIdArray as &$userId) {
            $db->addUserToGroup($groupId, $userId);
        }

        // If the current user is not in the list, add the user too
        if (!in_array($session->getData("UserId"), $userIdArray)) {
            $db->addUserToGroup($groupId, $session->getData("UserId"));
        }

        // Reload the page
        $header->setHeader("mHome");
    }

    function openGroup($groupId) {
        global $session;
        $session->putData("GroupId", $groupId);
        exit;
    }

    function sendMessage($message) {
        global $session;
        global $db;
        
        $userId = $session->getData("UserId");
        $groupId = $session->getData("GroupId");

        if (isset($groupId) && isset($userId)) {
            $messageId = $db->sendMessage($groupId, $userId, $message);
            echo $messageId;
            exit;
        }
    }

    function loadMessages() {
        global $session;
        global $db;
        
        // TODO: Security - Check if user is in the group

        $groupId = $session->getData("GroupId");
        $userId = $session->getData("UserId");

        if (isset($groupId)) {
            $messages = $db->single_dynamic_query("SELECT user.id, user.firstname, user.lastname, message.date, message.id, message_text.data FROM message INNER JOIN user ON message.user_id = user.id INNER JOIN message_text ON message.id = message_text.id WHERE groupchat_id = '$groupId' ORDER BY message.date");

            if ($messages != "false") {
                $result = '';

                for ($i = 0; $i < count($messages[0]); $i++) {
                    for ($j = 0; $j < count($messages[0][$i]); $j++) {
                        if ($j == 0) {
                            if ($messages[0][$i][0] == $userId) {
                                $result .= "true";
                            } else {
                                $result .= "false";
                            }
                        } else {
                            $result .= $messages[0][$i][$j];
                        }
                        
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
                echo "No message to display.";
            }
            exit;
        }
    }
}

$actionObj = new Action($_REQUEST['action']);
?>