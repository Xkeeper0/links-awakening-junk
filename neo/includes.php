<?php

	error_reporting(E_ALL | E_NOTICE);
	// Define if we are in CLI mode or not (for some scripts)
	define("IS_CLI", (PHP_SAPI == "cli" ? true : false));

	require_once("autoload.php");
