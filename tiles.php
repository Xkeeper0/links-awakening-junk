<?php

	$i1	= imagecreatetruecolor(256, 256);
	$i2	= imagecreatefrompng("tiles.png");

	for ($i = 0; $i < 256; $i++) {

		$x	= $i % 16;
		$y	= floor($i / 16);

		imagecopy($i1, $i2, $x * 16, $y * 16, $x * 17 + 1, $y * 17 +1, 16, 16);

	}

	header("Content-type: image/png");
	imagepng($i1);

	imagedestroy($i1);
	imagedestroy($i2);
?>