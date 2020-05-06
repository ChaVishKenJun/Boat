<?php
class Menu {
	var $menu;
	
	function Menu($menu) {
		if (!empty($menu) and !is_numeric($menu)) {
			$this->BuildNavigation($menu);
		} else {
			$this->BuildNavigation("mHome");
		}
	}
	
	public function BuildNavigation($menu) {
		global $session;

		if ($menu == "mHome" && $session->getData("SignedIn") != "true") {
			$menu = "mSignIn";
			$session->putData("SignInMessage", "Please sign in first.");
		}

		switch ($menu) {
			case "mHome":
				$title = "Home";
				$content = PATH_CONTENT . "home.php";
				$leftbox = PATH_LEFTBOX . "home.php";
				$footer = PATH_FOOTER . "footer.php";
				break;
			case "mSignIn":
				$title = "Sign In";
				$content = PATH_CONTENT . "signIn.php";
				$leftbox = PATH_LEFTBOX . "empty.php";
				$footer = PATH_FOOTER . "footer.php";
				break;
			case "mSignUp":
				$title = "Sign Up";
				$content = PATH_CONTENT . "signUp.php";
				$leftbox = PATH_LEFTBOX . "empty.php";
				$footer = PATH_FOOTER . "footer.php";
				break;
			default:
				echo("Page Not Found");
		}

		$GLOBALS["title"] = $title;
		$GLOBALS["content"] = $content;
		$GLOBALS["leftbox"] = $leftbox;
		$GLOBALS["footer"] = $footer;
	}
}

$menuObj = new Menu($_GET['menu']);

?>