<?php

//	$file	= intval($_GET['f']);
//	$data	= file_get_contents("save$file.sav");
	ini_set("memory_limit", "256M");

	$action	= array(
		"2"	=> "Open doors",
		"4"	=> "Kill all enemies",
		"6"	=> "Spawn chest",
		"8"	=> "Key drops",
		"A"	=> "Staircase appears",
		"C"	=> "Miniboss killed",
//		"E"	=> "",
		);

	$trigger	= array(
		"1"	=> "Kill all",
		"2"	=> "Push block",
		"3"	=> "Push trigger",
//		"4"	=> "",
		"5"	=> "Light torches",
		"6"	=> "L2 NMKey Puzzle",
		"7"	=> "Push two blocks ",
		"8"	=> "Kill special",
		"9"	=> "L4 Glint puzzle",
		"A"	=> "Defeat boss 4/7",
		"B"	=> "Throw pot at door",
		"C"	=> "Upright horses",
		"D"	=> "Hit chest w/ pot",
		"E"	=> "L8 Hole filling",
		"F"	=> "Hit statue w/arrow",
		);

	$fname	= "la12.gbc";
	$data	= file_get_contents($fname);

	$size	= 32;
	$scale	= ($_GET['s'] ? 4 : 1);
	$xsize	= 160 / $scale;
	$ysize	= 128 / $scale;

	$m		= min(max(intval($_GET['m']), 1), 2);
	$base['events'][1]		= 0x050000;
	$base['events'][2]		= 0x050100;
	$data	= substr($data, $base['events'][$m], 256);

//	$image	= imagecreatetruecolor(16 * $xsize, 16 * $ysize);
	$image	= imagecreatefrompng("bigmap$m". ($_GET['s'] ? "-s" : "") .".png");
///	imagefilledrectangle($image, 0, 0, 16 * $size, 16 * $size, 0x000080);


	$border	= imagecolorallocatealpha($image, 0, 0, 0, 80);
	$col[0]	= imagecolorallocatealpha($image, 0, 0, 0, 30);
	$col[1]	= imagecolorallocatealpha($image, 100,  75,  50, 70);
	$col[2]	= imagecolorallocatealpha($image, 100, 255, 100, 70);
	$col[3]	= imagecolorallocatealpha($image, 100, 100, 255, 70);

	for ($i	= 0; $i <= 255; $i++) {
		$o	= $i + $offset;
		$val	= ord($data{$o});

		$val2	= hexout($val);
		$a		= substr($val2, 0, 1);
		$t		= substr($val2, 1, 1);

		$color	= 0;

		if ($val == 0) {
			$col1	= 0x808080;
			$col2	= 0x000000;
		} else {
			$col1	= 0xffffff;
			$col2	= 0x000000;
			$color	= 1;
		}
		
		$atext	= ($action[$a] ? $action[$a] : "Unknown");
		if (substr($atext, 0, 1) == "!") {
			$atext	= substr($atext, 1);
			$color	= 2;
		} elseif ($atext == "Unknown" && $val) {
			$color	= 3;
		}

		$ttext	= ($trigger[$t] ? $trigger[$t] : "Unknown");
		if (substr($ttext, 0, 1) == "!") {
			$ttext	= substr($ttext, 1);
			$color	= 2;
		} elseif ($ttext == "Unknown" && $val) {
			$color	= 3;
		}

		imagefilledrectangle($image, $i % 16 * $xsize, floor($i / 16) * $ysize, $i % 16 * $xsize + $xsize - 1, floor($i / 16) * $ysize + $ysize - 1, $col[$color]);

		$text	= strtoupper(str_pad(dechex($val), 2, "0", STR_PAD_LEFT));

		if ($xsize == 160) {
			imageoutlinetext($image, 5, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 10, $text, $col1, $col2);
			if ($val) imageoutlinetext($image, 3, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 24, $a ." ". $atext, $col1, $col2);
			if ($val) imageoutlinetext($image, 3, $i % 16 * $xsize + 12, floor($i / 16) * $ysize + 36, $t ." ". $ttext, $col1, $col2);

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

	function hexout($v, $l = 2) {
		return str_pad(strtoupper(dechex($v)), $l, "0", STR_PAD_LEFT);
	}

?>