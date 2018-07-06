<?php
	
	if ($_GET['stupid']) {
		$img	= imagecreate(2048, 2048); // + 30);
		$maxy	= 2050;
		$offset	= 0x000000;
		$rows	= 256;
		$cols	= 256;
		$tilec	= 0x00FFFF;
		set_time_limit(0);
		ini_set("memory_limit", "256M");
	} else {
		$img	= imagecreate(8 * 16, 8 * 16);
		$offset	= 0x0CB100;
		$rows	= 16;
		$cols	= 16;
		$tilec	= 0x000100;
	}

	$data	= file_get_contents("la12.gbc");

//	$col[0xFF]	= imagecolorallocate($img,   0,   0, 255);
	$col[0]		= imagecolorallocate($img, 255, 255, 255);
	$col[1]		= imagecolorallocate($img, 170, 170, 170);
	$col[2]		= imagecolorallocate($img,  85,  85,  85);
	$col[3]		= imagecolorallocate($img,   0,   0,   0);

/*
	print "<pre>";
	for ($bit = 0; $bit < 0x80; $bit+=8) {
		$o	= floor($offset + floor($bit / 8));
		print str_replace(array("0", "1"), array(".", "@"), str_pad(decbin(ord($data{$o})), 8, "0", STR_PAD_LEFT) ." ");
		if (!(($bit + 8) % 0x10)) print "\n";
		imagesetpixel($img, $x, $y, $col[$color]);
	}
	die();
*/

	$starttime	= microtime(true);
	
	for ($tiles = 0; $tiles <= $tilec; $tiles++) {
		$x	= $tiles % $cols * 8;
		$y	= floor($tiles / $cols) * 8;
		$start	= $offset + $tiles * 0x10;

		for ($bit = 0; $bit < 0x40; $bit+=1) {
			$px	= $bit % 8 + $x;
			$py	= floor($bit / 8) + $y;
			$byte	= floor($bit / 8) * 2;

			$o	= floor($start + $byte);
			$bs	= 7 - ($bit % 8);
			$color	= (ord($data{$o}) >> $bs) & 0x1;

			$o	= floor($start + $byte) + 1;
			$bs	= 7 - ($bit % 8);
			$color2	= (ord($data{$o}) >> $bs) & 0x1;

			$color	= $color | ($color2 << 1);

			imagesetpixel($img, $px, $py, $col[$color]);
		}
		$counter++;
	}

	$time	= microtime(true) - $starttime;
	imagestring($img, 1, 5, $maxy, "$counter tiles in ". number_format($time, 3) ."sec", $col[0]);

	header("Content-type: image/png");
	imagepng($img);

	imagedestroy($img);
?>