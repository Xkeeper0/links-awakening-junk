<?php

//	$file	= intval($_GET['f']);
//	$data	= file_get_contents("save$file.sav");
	ini_set("memory_limit", "256M");


	$fname	= "la12.gbc";
	$data	= file_get_contents($fname);

	$size	= 32;
	$scale	= ($_GET['s'] ? 4 : 1);
	$xsize	= 160 / $scale * 2;
	$ysize	= 128 / $scale * 2;

	$base['tilesets']		= 0x069E76; // ?
	$base['tilesets']		= 0x082E7B; // ?
	$save	= substr($data, $base['tilesets'], 512);

//	$image	= imagecreatetruecolor(16 * $xsize, 16 * $ysize);
//	$image	= imagecreatefrompng("bigmap0.png");
	$image	= imagecreatefrompng("bigmap0". ($_GET['s'] ? "-s" : "") .".png");

///	imagefilledrectangle($image, 0, 0, 16 * $size, 16 * $size, 0x000080);


	$border	= imagecolorallocatealpha($image, 0, 0, 0, 80);
	$col[0]	= imagecolorallocatealpha($image, 0, 0, 0, 50);

//	for ($i	= 0; $i <= 255; $i++) {
	for ($i	= 0; $i <= 64; $i++) {
		$o	= $i * 2 + $offset;
		$o	= $i * 1 + $offset;
		$o	= floor($i * 1) % 8 + floor($i / 8) * 8 + $offset;
		$val2	= ord($save{$o});
//		$val2	= ord($save{$o + 1});

		if ($val) $color = 1;
		else $color = 1;	// 0

//		$color	= imagecolorallocatealpha($image, $val2, $val2, $val2, 50);
		$cv		= ($val2 - 0x0F) / (0x3E - 0x0F) * 0xFF; //($val2 - 22) * 40;
		$color	= imagecolorallocatealpha($image, $cv, $cv, $cv, 50);
/*		if ($val == 0x20) {
			$col1	= 0xccffcc;
			$col2	= 0x000000;
			$color	= imagecolorallocatealpha($image, $val2, 0xff, 0xff, 50);
		} elseif ($val == 0x40) {
			$col1	= 0xffcccc;
			$col2	= 0x000000;
			$color	= imagecolorallocatealpha($image, 0xff, $val2, 0xff, 50);
		} else {
*/			$col1	= 0xffffff;
			$col2	= 0x000000;
//		}


		imagefilledrectangle($image, $i % 8 * $xsize, floor($i / 8) * $ysize, $i % 8 * $xsize + $xsize - 1, floor($i / 8) * $ysize + $ysize - 1, $color);
		imagerectangle      ($image, $i % 8 * $xsize, floor($i / 8) * $ysize, $i % 8 * $xsize + $xsize, floor($i / 8) * $ysize + $ysize, $border);

		$text	= strtoupper(str_pad(dechex($val), 2, "0", STR_PAD_LEFT)) . strtoupper(str_pad(dechex($val2), 2, "0", STR_PAD_LEFT));
		$text	= strtoupper(str_pad(dechex($val2), 2, "0", STR_PAD_LEFT));
		$bin1	= str_pad(decbin($val), 8, "0", STR_PAD_LEFT);
		$bin2	= str_pad(decbin($val2), 8, "0", STR_PAD_LEFT);

		if ($xsize == 160 * 2) {
			imageoutlinetext($image, 5, $i % 8 * $xsize + 8, floor($i / 8) * $ysize + 10, $text, $col1, $col2);
//			imageoutlinetext($image, 3, $i % 8 * $xsize + 8, floor($i / 8) * $ysize + 24, $bin2, $col1, $col2);

			imageoutlinetext($image, 3, $i % 8 * $xsize + 32, floor($i / 8) * $ysize + 11, "0x". strtoupper(dechex($base['tilesets'] + $o)), $col1, $col2);
//			imageoutlinetext($image, 3, $i % 8 * $xsize + 8, floor($i / 8) * $ysize + 44, "0x". dechex($base['tilesets'] + $o), $col1, $col2);
//			imageoutlinetext($image, 3, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 24, $bin1, $col1, $col2);
//			imageoutlinetext($image, 3, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 34, $bin2, $col1, $col2);

		} else {
			imageoutlinetext($image, 3, $i % 8 * $xsize + 4, floor($i / 8) * $ysize + 2, $text, $col1, $col2);
		}

	}

	header("Content-type: image/png");
	imagepng($image);
	imagedestroy($image);


	function imageoutlinetext($i, $s, $x, $y, $text, $c1, $c2) {
		imagestring			($i, $s, $x + 1, $y    , $text, $c2);
		imagestring			($i, $s, $x    , $y + 1, $text, $c2);
		imagestring			($i, $s, $x - 1, $y    , $text, $c2);
		imagestring			($i, $s, $x    , $y - 1, $text, $c2);
		imagestring			($i, $s, $x + 1, $y + 1, $text, $c2);
		imagestring			($i, $s, $x - 1, $y + 1, $text, $c2);
		imagestring			($i, $s, $x - 1, $y - 1, $text, $c2);
		imagestring			($i, $s, $x + 1, $y - 1, $text, $c2);
		imagestring			($i, $s, $x, $y, $text, $c1);
	}

?>