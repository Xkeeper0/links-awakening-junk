<?php
	

	$base['tsa']	= 0x6AB1D;

	$tiles			= imagecreatefrompng("temp.png");
	$img			= imagecreatetruecolor(44 * 17, 34 * 17);
	$data			= file_get_contents("la12.gbc");

	$colred			= imagecolorallocatealpha($img, 255, 80, 80, 80);
	$colgreen		= imagecolorallocatealpha($img, 80, 255, 80, 80);

	for ($i = 0; $i <= 15; $i++) {
		$y		= $i * 17 + 17;
		imagestring($img, 4, 4, $y, hexout($i, 1), 0xFFFFFF);
		$x		= $i * 17 + 17;
		imagestring($img, 4, $x + 4, 1, hexout($i, 1), 0xFFFFFF);
	}


	imagestring($img, 3, 580, 100, "Top left    = 0x". hexout($base['tsa']), 0xFFFFFF);
	for ($i = 0; $i <= 0xFF; $i++) {
		$x		= $i % 16 * 17 + 17;
		$y		= floor($i / 16) * 17 + 17;
		$o		= $i * 4 + $base['tsa'];

		$t[0]		= ord($data{$o + 0});
		$t[1]		= ord($data{$o + 1});
		$t[2]		= ord($data{$o + 2});
		$t[3]		= ord($data{$o + 3});
		$tiledat[$i]	= $t;
		for ($tn = 0; $tn <= 3; $tn++) {
			$x2	= $x + $tn % 2 * 8;
			$y2	= $y + floor($tn / 2) * 8;
			$x3	= $t[$tn] % 16 * 8;
			$y3	= floor($t[$tn] / 16) * 8;
			imagecopy($img, $tiles, $x2, $y2, $x3, $y3, 8, 8);
		}
	}

	imagecopy($img, $img, 0, 289, 0, 0, 289, 289);

	$o		= $base['tsa'] - 0x400 + 0xB * 4;
	imagestring($img, 3, 580, 113, "Bottom left = 0x". hexout($o), 0xFFFFFF);

	for ($i = 0; $i <= 0xFF; $i++) {
		$x		= $i % 16 * 17 + 17;
		$y		= floor($i / 16) * 17 + 289 + 17;
		$o		= $i * 4 + $base['tsa'] - 0x400 + 0xB * 4;

		$t[0]		= ord($data{$o + 0});
		$t[1]		= ord($data{$o + 1});
		$t[2]		= ord($data{$o + 2});
		$t[3]		= ord($data{$o + 3});

		for ($tn = 0; $tn <= 3; $tn++) {
			$x2	= $x + $tn % 2 * 8;
			$y2	= $y + floor($tn / 2) * 8;
			$x3	= $t[$tn] % 16 * 8;
			$y3	= floor($t[$tn] / 16) * 8;
			imagecopy($img, $tiles, $x2, $y2, $x3, $y3, 8, 8);
			if ($tiledat[$i][$tn] == $t[$tn]) {
				imagefilledrectangle($img, $x2, $y2, $x2 + 7, $y2 + 7, $colgreen);
			} else {
				imagefilledrectangle($img, $x2, $y2, $x2 + 7, $y2 + 7, $colred);
			}
		}
	}


	imagecopy($img, $img, 289, 0, 0, 0, 289, 289);
	imagedestroy($tiles);
	$tiles			= imagecreatefrompng("extra/acmlm/dtiles.png");

	$base2	= rand(0x10000, 0x80000); // 0x6A309 + 0x40; //0x68000 + $_GET['n'] * 0x400 + 9;

	$base2	= 0x203C4 - 4 * 5;
	imagestring($img, 3, 580, 126, "Top right   = 0x". hexout($base2), 0xFFFFFF);

	for ($i = 0; $i <= 0xFF; $i++) {
		$x		= $i % 16 * 17 + 17 + 289;
		$y		= floor($i / 16) * 17 + 17;
		$o		= $i * 4 + $base2;

		$t[0]		= ord($data{$o + 0});
		$t[1]		= ord($data{$o + 1});
		$t[2]		= ord($data{$o + 2});
		$t[3]		= ord($data{$o + 3});
		$tiledat[$i]	= $t;

		for ($tn = 0; $tn <= 3; $tn++) {
			$x2	= $x + $tn % 2 * 8;
			$y2	= $y + floor($tn / 2) * 8;
			$x3	= $t[$tn] % 16 * 8;
			$y3	= floor($t[$tn] / 16) * 8;
			imagecopy($img, $tiles, $x2, $y2, $x3, $y3, 8, 8);
		}
	}

	
	
	imagecopy($img, $img, 289, 289, 0, 0, 289, 289);

	$base2	= rand(0x10000, 0x80000); // 0x6A309 + 0x40; //0x68000 + $_GET['n'] * 0x400 + 9;

	$base2	= 0x203C4 - 4 * 5 + 0x400 - 80;	// Color Dungeon
	$base2	= 0x203C4 + 4 * 0xF - 0x400;
	imagestring($img, 3, 580, 140, "Bottom right= 0x". hexout($base2), 0xFFFFFF);

	for ($i = 0; $i <= 0xFF; $i++) {
		$x		= $i % 16 * 17 + 17 + 289;
		$y		= floor($i / 16) * 17 + 17 + 289;
		$o		= $i * 4 + $base2;

		$t[0]		= ord($data{$o + 0});
		$t[1]		= ord($data{$o + 1});
		$t[2]		= ord($data{$o + 2});
		$t[3]		= ord($data{$o + 3});

		for ($tn = 0; $tn <= 3; $tn++) {
			$x2	= $x + $tn % 2 * 8;
			$y2	= $y + floor($tn / 2) * 8;
			$x3	= $t[$tn] % 16 * 8;
			$y3	= floor($t[$tn] / 16) * 8;
			imagecopy($img, $tiles, $x2, $y2, $x3, $y3, 8, 8);
			if ($tiledat[$i][$tn] == $t[$tn]) {
				imagefilledrectangle($img, $x2, $y2, $x2 + 7, $y2 + 7, $colgreen);
			} else {
				imagefilledrectangle($img, $x2, $y2, $x2 + 7, $y2 + 7, $colred);
			}
		}
	}

	header("Content-type: image/png");
	imagepng($img);
	imagedestroy($img);
	imagedestroy($tiles);







	function hexout($v, $l = 2) {
		return str_pad(strtoupper(dechex($v)), $l, "0", STR_PAD_LEFT);
	}
?>