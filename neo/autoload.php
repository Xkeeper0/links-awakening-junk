<?php

	// Require the important stuff
	function la_autoloader($class) {
		$file	= __DIR__ ."/lib/". str_replace('\\', '/',$class) .".php";
		//printf("Autoloading: %s from %s<br>\n", $class, $file);
		if (file_exists($file)) {
			require_once($file);
		}
	}
	spl_autoload_register("la_autoloader");
