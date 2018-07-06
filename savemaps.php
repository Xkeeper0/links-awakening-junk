<?php

	$file	= intval($_GET['f']);
	$data	= file_get_contents("save$file.sav");
	ini_set("memory_limit", "256M");


	$length	= 0x3ad - ($_GET['dx'] ? 0 : 0x28);
	$start	= 0x105;
	$rstart	= ($start + $length * $_GET['s']);

	$save	= substr($data, $rstart, $length);

	$size	= 32;
	$xsize	= 160 / ($_GET['b'] ? 1 : 4);
	$ysize	= 128 / ($_GET['b'] ? 1 : 4);

	$m		= min(max(intval($_GET['m']), 0), 3);
	$offset	= 256 * $m;

//	$image	= imagecreatetruecolor(16 * $xsize, 16 * $ysize);
	$image	= imagecreatefrompng("bigmap$m". ($_GET['b'] ? "" : "-s") .".png");
///	imagefilledrectangle($image, 0, 0, 16 * $size, 16 * $size, 0x000080);


	$border	= imagecolorallocatealpha($image, 0, 0, 0, 60);

	for ($i	= 0; $i <= 255; $i++) {
		$o	= $i + $offset;
		$val	= ord($save{$o});
		if (!$col[$val]) {
			$col[$val]	= imagecolorallocatealpha($image, $val, $val, $val, 50);
		}

		if ($val == 0) {
			$col1	= 0x808080;
			$col2	= 0x000000;
		} else {
			$col1	= 0xffffff;
			$col2	= 0x000000;
		}

//		imagefilledrectangle($image, $i % 16 * $size, floor($i / 16) * $size, $i % 16 * $size + $size - 1, floor($i / 16) * $size + $size - 1, $col);
		imagefilledrectangle($image, $i % 16 * $xsize, floor($i / 16) * $ysize, $i % 16 * $xsize + $xsize - 1, floor($i / 16) * $ysize + $ysize - 1, $col[$val]);
		imagerectangle      ($image, $i % 16 * $xsize, floor($i / 16) * $ysize, $i % 16 * $xsize + $xsize, floor($i / 16) * $ysize + $ysize, $border);

		$text	= strtoupper(str_pad(dechex($val), 2, "0", STR_PAD_LEFT));
		$bin	= str_pad(decbin($val), 8, "0", STR_PAD_LEFT);
//		$bin	= str_replace(array("0", "1"), array("-", "X"), $bin);

		if ($xsize == 160) {
			imageoutlinetext($image, 5, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 10, $text, $col1, $col2);
			imageoutlinetext($image, 3, $i % 16 * $xsize + 34, floor($i / 16) * $ysize + 11, $bin, $col1, $col2);

			imageoutlinetext($image, 2, $i % 16 * $xsize + 30, floor($i / 16) * $ysize + 40, "", $col1, $col2);
			if ($val & 0x4)	imageoutlinetext($image, 3, $i % 16 * $xsize + 30, floor($i / 16) * $ysize + 29, "U", $col1, $col2);
			if ($val & 0x2)	imageoutlinetext($image, 3, $i % 16 * $xsize + 23, floor($i / 16) * $ysize + 37, "L", $col1, $col2);
			if ($val & 0x1)	imageoutlinetext($image, 3, $i % 16 * $xsize + 37, floor($i / 16) * $ysize + 37, "R", $col1, $col2);
			if ($val & 0x8)	imageoutlinetext($image, 3, $i % 16 * $xsize + 30, floor($i / 16) * $ysize + 45, "D", $col1, $col2);
		} else {
			imageoutlinetext($image, 3, $i % 16 * $xsize + 4, floor($i / 16) * $ysize + 2, $text, $col1, $col2);
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