<?php 
class Cookies {
		
		function putData($ident,$wert) {
			setcookie($ident,$wert,time()+3600);
		}
		
		function getData($ident) {
			$result = $_COOKIE[$ident];
			return $result;
		}
		
		function unsetData($ident) {
			unset($_COOKIE[$ident]);
		}
		
		function unsetAll() {
			unset($_COOKIE);
		}
		

	
}
$cookies = new Cookies;


?>