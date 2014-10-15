<?php

if(!isset($_SESSION)) {
     session_start();
}

function TurnDebugOn() {
	$_SESSION["debug"] = true;
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
}

function TurnDebugOff() {
	$_SESSION["debug"] = false;
	error_reporting(0);
}

function DebugFlag() {
	return (isset($_SESSION["debug"]) && $_SESSION["debug"] === true);
}

function trace($str) {
	if (DebugFlag() && !defined("AJAX_POST_REQUEST")) {
		echo " > ".$str."<br/>\n";
	}
}
?>