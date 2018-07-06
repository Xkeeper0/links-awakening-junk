<?php

//	$file	= intval($_GET['f']);
//	$data	= file_get_contents("save$file.sav");
	ini_set("memory_limit", "256M");

	$contents	= array(

		0x01	=> "Mirror Shield",
		0x02	=> "!Bow?!",
		0x03	=> "!Hookshot",
		0x04	=> "Fire Rod",
		0x05	=> "Pegasus Boots",
		0x06	=> "Ocarina",
		0x07	=> "Roc's Feather",
		0x08	=> "!Shovel!?",
		0x09	=> "!Magic Powder",
		0x0a	=> "One bomb",
		0x0b	=> "!Sword L-1",		// "Found your sword" stuff
		0x0c	=> "Flippers",
		0x0d	=> "!Magnifying Lens",	// doesn't act like it, but pops up a copy of your trading item
		0x0e	=> "!Sword",			// "You got a new sword! You should put your name on it right away!"
		0x0f	=> "!Sword",			// "You got a new sword! You should put your name on it right away!"
		0x10	=> "Medicine",
		0x11	=> "Tail Key",
		0x12	=> "!Slime Key",		// All of these use some wrong graphics
		0x13	=> "!Angler Key",		// All keys, but not the correct ones
		0x14	=> "!Face Key",
		0x15	=> "!Bird Key",
		0x16	=> "Map",
		0x17	=> "Compass",
		0x18	=> "Owl Beak",
		0x19	=> "Nightmare Key",
		0x1a	=> "Small key",
		0x1b	=> "50 Rupees",
		0x1c	=> "20 Rupees",
		0x1d	=> "100 Rupees",
		0x1e	=> "200 Rupees",
		0x1f	=> "!200 Rupees",
		0x20	=> "Secret Seashell",
		0x21	=> "Hookshot note",
		0x22	=> "Gel",

		);

	$fname	= "la12.gbc";
	$data	= file_get_contents($fname);

	$size	= 32;
	$scale	= ($_GET['s'] ? 4 : 1);
	$xsize	= 160 / $scale;
	$ysize	= 128 / $scale;

	$m		= min(max(intval($_GET['m']), 0), 3);

	$base['chests'][0]		= 0x050560;
	$base['chests'][1]		= 0x050660;
	$base['chests'][2]		= 0x050760;
	$base['chests'][3]		= 0x050860;

	$baseaddr	= $base['chests'][$m];

        if ($_GET['o-m']) {
                $baseaddr      = 0x050560 + 0x100 * $_GET['o-m'];
        }


	$save	= substr($data, $baseaddr, 256);

//	$image	= imagecreatetruecolor(16 * $xsize, 16 * $ysize);
	$image	= imagecreatefrompng("bigmap$m". ($_GET['s'] ? "-s" : "") .".png");
///	imagefilledrectangle($image, 0, 0, 16 * $size, 16 * $size, 0x000080);


	$border	= imagecolorallocatealpha($image, 0, 0, 0, 80);
	$col[0]	= imagecolorallocatealpha($image, 0, 0, 0, 50);
	$col[1]	= imagecolorallocatealpha($image, 255, 220, 90, 80);
	$col[2]	= imagecolorallocatealpha($image, 100, 255, 100, 80);
	$col[3]	= imagecolorallocatealpha($image, 100, 100, 255, 80);

	for ($i	= 0; $i <= 255; $i++) {
		$o	= $i + $offset;
		$val	= ord($save{$o});

		if ($val) $color = 1;
		else $color = 0;

		$ctext	= ($contents[$val] ? $contents[$val] : "Unknown");
		if (substr($ctext, 0, 1) == "!") {
			$ctext	= substr($ctext, 1);
			$color	= 2;
		} elseif ($ctext == "Unknown" && $val) {
			$color	= 3;
		}

		if ($val == 0) {
			$col1	= 0x808080;
			$col2	= 0x000000;
		} else {
			$col1	= 0xffffff;
			$col2	= 0x000000;
		}

//		imagefilledrectangle($image, $i % 16 * $size, floor($i / 16) * $size, $i % 16 * $size + $size - 1, floor($i / 16) * $size + $size - 1, $col);
		imagefilledrectangle($image, $i % 16 * $xsize, floor($i / 16) * $ysize, $i % 16 * $xsize + $xsize - 1, floor($i / 16) * $ysize + $ysize - 1, $col[$color]);
//		imagerectangle      ($image, $i % 16 * $xsize, floor($i / 16) * $ysize, $i % 16 * $xsize + $xsize, floor($i / 16) * $ysize + $ysize, $border);

		$text	= strtoupper(str_pad(dechex($val), 2, "0", STR_PAD_LEFT));
//		$bin	= str_pad(decbin($val), 8, "0", STR_PAD_LEFT);
//		$bin	= str_replace(array("0", "1"), array("-", "X"), $bin);

		if ($xsize == 160) {
			imageoutlinetext($image, 5, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 10, $text, $col1, $col2);
			if ($val) imageoutlinetext($image, 3, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 24, $ctext, $col1, $col2);
			if ($val) imageoutlinetext($image, 3, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 36, strtoupper(str_pad(dechex($baseaddr + $o), 2, "0", STR_PAD_LEFT)), $col1, $col2);

//			imageoutlinetext($image, 2, $i % 16 * $xsize + 30, floor($i / 16) * $ysize + 40, "°", $col1, $col2);
//			if ($val & 0x4)	imageoutlinetext($image, 3, $i % 16 * $xsize + 30, floor($i / 16) * $ysize + 29, "U", $col1, $col2);
//			if ($val & 0x2)	imageoutlinetext($image, 3, $i % 16 * $xsize + 23, floor($i / 16) * $ysize + 37, "L", $col1, $col2);
//			if ($val & 0x1)	imageoutlinetext($image, 3, $i % 16 * $xsize + 37, floor($i / 16) * $ysize + 37, "R", $col1, $col2);
//			if ($val & 0x8)	imageoutlinetext($image, 3, $i % 16 * $xsize + 30, floor($i / 16) * $ysize + 45, "D", $col1, $col2);
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
