<?php
/*
	The important thing to realize is that the config file should be included in every
	page of your project, or at least any page you want access to these settings.
	This allows you to confidently use these settings throughout a project because
	if something changes such as your database credentials, or a path to a specific resource,
	you'll only need to update it here.
*/
$config = array(
	"db" => array(
		"main" => array(
			//"dbname" => "",
			//"username" => "",
			//"password" => "",
			//"host" => "localhost",
            "mode" => SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE
		)
	),
	"urls" => array(
		"baseUrl" => "http://arasaia.net/recipe" //change this to the root of your application
	),
	"paths" => array(
		"images" => $_SERVER["DOCUMENT_ROOT"] . "/images"
	)
);

/*

	I will usually place the following in a bootstrap file or some type of environment
	setup file (code that is run at the start of every page request), but they work 
	just as well in your config file if it's in php (some alternatives to php are xml or ini files).
*/

/*

	Creating constants for heavily used paths makes things a lot easier.
	ex. require_once(LIBRARY_PATH . "Paginator.php")

*/
defined("INDEX_PATH")
    or define("INDEX_PATH", realpath(dirname(__FILE__)));

defined("INCLUDES_PATH")
	or define("INCLUDES_PATH", realpath(dirname(__FILE__) . '/includes'));

defined("SERVICES_PATH")
	or define("SERVICES_PATH", realpath(dirname(__FILE__) . '/services'));

defined("TEMPLATES_PATH")
	or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
?>