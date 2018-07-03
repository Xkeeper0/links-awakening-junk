<?php

	return header("Location: savedata.php");

	$data	= file_get_contents("save3.sav");
	ini_set("memory_limit", "256M");


	$length	= 0x3ab;
	$start	= 0x105;

	for ($i = 0; $i < 3; $i++) {
		print "Map data $i:
				<br><img src=\"savemaps.php?m=$i\">
				<br>
				<br>";
	}



?>