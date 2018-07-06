<?php

	$i	= imagecreatetruecolor(256, 256);
	$b	= imagecolorallocate($i, 127, 0, 0);
	$c	= imagecolorallocate($i, 255, 255, 255);
	for ($n = 0; $n < 256; $n++) {

		$t	= hexout($n);
		$c	= imagecolorallocate($i, $n / 1.5, $n / 1.5, 100 + $n / 2);
		if ($n >= 0xf5) $c	= imagecolorallocate($i, 128 + ($n - 0xf5) * 11, ($n - 0xf5) * 6, ($n - 0xf5) * 6);
		imagefilledrectangle($i, $n % 16 * 16, floor($n / 16) * 16, $n % 16 * 16 + 16, floor($n / 16) * 16 + 16, $c);
		$c	= imagecolorallocate($i, 255, 255, 255);
		imagestring($i, 1, $n % 16 * 16 + 3, floor($n / 16) * 16 + 4, $t, $c);
	}

	header("Content-type: image/png");
	imagepng($i);
	imagedestroy($i);
	
	
	
	
	function hexout($char, $l = 2) {
		return str_pad(dechex($char), $l, "0", STR_PAD_LEFT);
	}

?>