<?php
class Header {
	function setHeader($menu) {
		$this->host = $_SERVER["HTTP_HOST"];
		$this->uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: http://$this->host$this->uri/index.php?menu=$menu");
		exit;
	}
}

$header = new Header();