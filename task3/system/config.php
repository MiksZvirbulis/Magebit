<?php
ob_start();
if(!defined("IN_SYSTEM")){
    header("Location: /");
    exit();
};

# Timezone
date_default_timezone_set("Europe/Riga");

# Configuration
$config = array(
	# General
	"title" => "Pinapple Sunglasses",
	"debug" => true,
	
	# Do not touch
    "url" => "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'],
    "dir" => $_SERVER['DOCUMENT_ROOT'],

	# Database authorisation
	"sql_host" => "localhost", // SQL Host
	"sql_username" => "root", // SQL Username
	"sql_password" => "pineapple123", // SQL Password
	"sql_database" => "pineapple" // SQL Database
	);

# Defining the settings
foreach($config as $var => $value){
	define($var, $value);
}

if (debug === true) {
	# If debug is set to true, display errors
	error_reporting(E_ALL | E_STRICT);
	ini_set("display_errors", 1);
}

require dir . "/system/classes/db.class.php";
$db = new db(sql_host, sql_username, sql_password, sql_database);