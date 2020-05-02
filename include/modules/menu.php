<?php
class Menu {
	var $menu;
	function Menu($menu) {
		if($menu!="" and !is_numeric($menu) and substr($menu, 0, 1)=="m") {	
			$this->BuildNavigation($menu);		
		} else {
			$this->BuildNavigation('mHome');	
		}
	}
	
	public function BuildNavigation($menu) {
		switch ($menu) {
		case "mHome":
			$title="ChaHan Library";
			$content = PATH_CONTENT . "home.php";
			$leftbox = PATH_LEFTBOX . "home.php";
			$footer = PATH_FOOTER . "footer.php";
		break 1; 
		case "mItems":
			$title="ChaHan Library - Items";
			$content = PATH_CONTENT . "items.php";
			$leftbox = PATH_LEFTBOX . "items.php";
			$footer = PATH_FOOTER . "footer.php";
		break 1; 
		case "mClients":
			$title="ChaHan Library - Clients";
			$content = PATH_CONTENT . "clients.php";
			$leftbox = PATH_LEFTBOX . "clients.php";
			$footer = PATH_FOOTER . "footer.php";
		break 1;
                            
		case "mSearch":
			$title="ChaHan Library - Items";
			$content = PATH_CONTENT . "search.php";
			$leftbox = PATH_LEFTBOX . "items.php";
			$footer = PATH_FOOTER . "footer.php";
		break 1; 
		case "mcreateOrEditItem":
			$title="ChaHan Library - Items";
			$content = PATH_CONTENT . "createOrEditItem.php";
			$leftbox = PATH_LEFTBOX . "items.php";
			$footer = PATH_FOOTER . "footer.php";
		break 1; 
                case "mcreateOrEditClient":
                        $title="ChaHan Library - Clients";
                        $content = PATH_CONTENT . "createOrEditClient.php";
                        $leftbox = PATH_LEFTBOX . "clients.php";
                        $footer = PATH_FOOTER . "footer.php";
                break 1; 
                case "mborrowItem":
                        $title="ChaHan Library - Items";
                        $content = PATH_CONTENT . "borrowItem.php";
                        $leftbox = PATH_LEFTBOX . "items.php";
                        $footer = PATH_FOOTER . "footer.php";
                break 1;
                case "mreturnItem":
                        $title="ChaHan Library - Items";
                        $content = PATH_CONTENT . "returnItem.php";
                        $leftbox = PATH_LEFTBOX . "items.php";
                        $footer = PATH_FOOTER . "footer.php";
                break 1; 
                case "mreserveItem":
                        $title="ChaHan Library - Items";
                        $content = PATH_CONTENT . "reserveItem.php";
                        $leftbox = PATH_LEFTBOX . "items.php";
                        $footer = PATH_FOOTER . "footer.php";
                break 1; 
		case "mLogIn":
			$title="ChaHan Library - LogIn";
			$content = PATH_CONTENT . "logIn.php";
			$leftbox = PATH_LEFTBOX . "home.php";
			$footer = PATH_FOOTER . "footer.php";
		break 1;
		default:
			$title="ChaHan Library";
			$content = PATH_CONTENT . "home.php";
			$leftbox = PATH_LEFTBOX . "home.php";
			$footer = PATH_FOOTER . "footer.php";
		}
		$GLOBALS['title']=$title;
		$GLOBALS['content']=$content;
		$GLOBALS['leftbox']=$leftbox;
		$GLOBALS['footer']=$footer;
	}
	
	
	
}
$menuObj = new Menu($_GET['menu']);







?>