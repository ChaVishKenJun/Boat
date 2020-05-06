<?php
class Session {
    function __construct() {
        $this->start();
    }

    function start() {
        session_start();
        //session_name("boat");
        session_regenerate_id();
    }

    function putData($id, $value) {
        $_SESSION["public"][$id] = $value;
    }

    function getData($id) {
        $result = $_SESSION["public"][$id];
        return $result;
    }

    function unsetData($id) {
        unset($_SESSION["public"][$id]);
    }

    /* Examples */
    function unsetDataCreateOrEditItem() {
        unset($_SESSION['public']['iItemIdValue']);
        unset($_SESSION['public']['iTitleValue']);
        unset($_SESSION['public']['iTypeValue']);
        unset($_SESSION['public']['iFirstNameValue']);
        unset($_SESSION['public']['iLastNameValue']);
        unset($_SESSION['public']['iCategoryValue']);
    }

    function unsetDataCreateOrEditItemValidation() {
        unset($_SESSION['public']['iFirstNameEmpty']);
        unset($_SESSION['public']['iLastNameEmpty']);
        unset($_SESSION['public']['iTitleEmpty']);
        unset($_SESSION['public']['iCategoryEmpty']);
        unset($_SESSION['public']['iTypeEmpty']);
        unset($_SESSION['public']['iItemExists']);
    }

    function unsetDataCreateOrEditClient() {
        unset($_SESSION['public']['cPersonIdValue']);
        unset($_SESSION['public']['cFirstNameValue']);
        unset($_SESSION['public']['cLastNameValue']);
        unset($_SESSION['public']['cMobileNumberValue']);
    }
    
    function unsetDataBorrowBook() {
        unset($_SESSION['public']['bTitleValue']);
        unset($_SESSION['public']['bDateFromValue']);
        unset($_SESSION['public']['bDateToValue']);
        unset($_SESSION['public']['bFirstNameValue']);
        unset($_SESSION['public']['bLastNameValue']);
    }

    function unsetDataCreateOrEditClientValidation() {
        unset($_SESSION['public']['cfirstNameEmpty']);
        unset($_SESSION['public']['clastNameEmpty']);
        unset($_SESSION['public']['cMobileNumberEmpty']);
        unset($_SESSION['public']['cMobileNumberString']);
        unset($_SESSION['public']['cClientExists']);
    }
    
    function unsetDataBorrowItemValidation() {
        unset($_SESSION['public']['bTitleEmpty']);
        unset($_SESSION['public']['bDateFromEmpty']);
        unset($_SESSION['public']['bDateToEmpty']);
        unset($_SESSION['public']['bDateFromWrongValue']);
        unset($_SESSION['public']['bDateToWrongValue']);
        unset($_SESSION['public']['bFirstNameEmpty']);
        unset($_SESSION['public']['bLastNameEmpty']);
        unset($_SESSION['public']['bClientNotExist']);
        unset($_SESSION['public']['bItemNotExist']);
        unset($_SESSION['public']['bItemNotAvailable']);
    }
    
    function unsetDataReturnItem() {
        unset($_SESSION['public']['rTitleValue']);
        unset($_SESSION['public']['rTypeValue']);
        unset($_SESSION['public']['rFirstNameValue']);
        unset($_SESSION['public']['rLastNameValue']);
    }
    
    function unsetDataReturnItemValidation() {
        unset($_SESSION['public']['rTitleEmpty']);
        unset($_SESSION['public']['rTypeEmpty']);
        unset($_SESSION['public']['rFirstNameEmpty']);
        unset($_SESSION['public']['rLastNameEmpty']);
        unset($_SESSION['public']['rClientNotExist']);
        unset($_SESSION['public']['rItemNotExist']);
    }

    function unsetDataReserveItem() {
        unset($_SESSION['public']['reTitleValue']);
        unset($_SESSION['public']['reDateFromValue']);
        unset($_SESSION['public']['reDateToValue']);
        unset($_SESSION['public']['reFirstNameValue']);
        unset($_SESSION['public']['reLastNameValue']);
    }
    
    function unsetDataReserveItemValidation() {
        unset($_SESSION['public']['reTitleEmpty']);
        unset($_SESSION['public']['reDateFromEmpty']);
        unset($_SESSION['public']['reDateToEmpty']);
        unset($_SESSION['public']['reDateFromWrongValue']);
        unset($_SESSION['public']['reDateToWrongValue']);
        unset($_SESSION['public']['reFirstNameEmpty']);
        unset($_SESSION['public']['reLastNameEmpty']);
        unset($_SESSION['public']['reClientNotExist']);
        unset($_SESSION['public']['reItemNotExist']);
        unset($_SESSION['public']['reItemNotAvailable']);
    }

    function unsetAllForm() {
        $this->unsetDataCreateOrEditItem();
        $this->unsetDataCreateOrEditClient();
        $this->unsetDataCreateOrEditClientValidation();
        $this->unsetDataBorrowItemValidation();
        $this->unsetDataBorrowBook();
        $this->unsetDataCreateOrEditItemValidation();
        $this->unsetDataReturnItem();
        $this->unsetDataReturnItemValidation();
        $this->unsetDataReserveItemValidation();
        $this->unsetDataReserveItem();
    }
    
    function unsetAll() {
        unset($_SESSION['public']);
    }
}

$session = new Session;
?>