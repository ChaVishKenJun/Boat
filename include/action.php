<?php
class Action {
	var $action;
	
	function Action($action) { // CLASS CONSTRUCTOR (HANDLER)
		global $security;
		
		//ACTION REQUEST
	
                if($action=="aCreateOrEditClient") {
			$this->CreateOrEditClient($_POST['personId'],$_POST['firstname'],$_POST['lastname'],$_POST['mobilenumber']);
		}
		if($action=="aCreateOrEditItem") {
			$this->CreateOrEditItem( $_POST['itemId'],$_POST['title'],$_POST['type'],$_POST['firstname'],$_POST['lastname'],$_POST['category']);
		}
		if($action=="aBorrowItem") {
			$this->BorrowItem($_POST['title'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['firstName'],$_POST['lastName']);
                }
                
		if($action=="aReturnItem") {
			$this->ReturnItem($_POST['title'],$_POST['type'],$_POST['firstName'],$_POST['lastName']);
                }
                if($action=="aReserveItem") {
			$this->ReserveItem($_POST['title'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['firstName'],$_POST['lastName']);
                }
                if($action == "aEditClient" && $_GET['PersonId'])
                {
                    $this->EditClient($_GET['PersonId']);
                }
		if($action == "aEditItem" && $_GET['ItemId'])
                {
                    $this->EditItem($_GET['ItemId']);
                }
                if($action == "aDeleteItem" && $_GET['ItemId'])
                {
                    $this->DeleteItem($_GET['ItemId']);
                }
                if($action == "aDeleteClient" && $_GET['PersonId'])
                {
                    $this->DeleteClient($_GET['PersonId']);
                }
		if($action=="aSignIn") {
			if($security->dataintegrity($_REQUEST)==1) {
			$this->SignIn($_POST['email'], $_POST['password']);	
			}  else { echo "XSS Attack"; exit; }  
		}
		if($action=="aSignUp") {
			if($security->dataintegrity($_REQUEST)==1) {
			$this->SignUp($_POST['firstname'], $_POST['lastname'],$_POST['email'], $_POST['password']);	
			}  else { echo "XSS Attack"; exit; }  
		}
		if($action=="aLogOut") {
			if($security->dataintegrity($_REQUEST)==1) {
			$this->LogOut();	
			}  else { echo "XSS Attack"; exit; }  
		}
		
		//ACTION REQUEST ENd
	}
	
	/////////// funktionen
        
        
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
	function LogOut() {
		global $session; 
		global $header;
		$session->PutData('LOGGEDIN',"false");
		$header->Header('mSiteOne');
	}
	
	
	
	function SignIn($email, $password) {	
		//Globalize
		global $header;
		global $security;
		global $session;
		global $db;
                
		$encryptet_pw = md5($password); 
                
		$iffound = $db->singlequery_dynamic("SELECT id from user WHERE email='$email' AND password='$encryptet_pw'");
                
		if($iffound=='false') {
			//user not found
			$session->PutData('signinattemptmessage', 1);
            $session->PutData('SIGNEDIN', "false");
                        $header->setHeader('mSignIn');                        
		} else {
            //user found
           
			$session->PutData('SIGNEDIN',"true");
			$session->unsetData('signinattemptmessage');
                        $header->setHeader('mHome');
		}
	}
    
    function SignUp($firstname, $lastname, $email, $password) {	
		//Globalize
		global $header;
		global $security;
		global $session;
		global $db;
                
		$encryptet_pw = md5($password); 
                
		$iffound = $db->singlequery_dynamic("SELECT id from user WHERE email='$email'");
                
        //check if item exists
		if($iffound=='false') {
            //user not found
            $session->unsetData('useralreadyexistmessage');
            $db->singlequery_dynamic("INSERT INTO user (firstname, lastname, email, password)"
            . "VALUES ('$firstname', '$lastname', '$email', '$encryptet_pw')");             
		} else {
            //user found           
            $session->PutData('useralreadyexistmessage', 1);
            
        }
        $header->setHeader('mSignUp');

	}
	
}

$actionObj = new Action($_REQUEST['action']);
//REQUEST - both post and get
?>