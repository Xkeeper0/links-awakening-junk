<?php

	if (!$_GET['saveas']) print "
		<style type=\"text/css\">
			body {
				font-family: Courier New, monospace;
				color: #99f;
				font-size:		1.0em;
				}
			table {
				font-size:	100%;
				}
			td	{
				background:		#113;
				border-right:	1px solid #336;
				border-bottom:	1px solid #559;
				padding:		.2em 1.5em .2em 1.5em;
				}
			.head	{
				background:		#202060;
				font-weight:	bold;
				border-right:	1px solid #336;
				border-bottom:	1px solid #559;
				}
			a	{
				color:			#9f9;
				}
		</style>
		
		<body bgcolor=050515><pre><font color=9999ff>";
	
	if ($_GET['anim']) {
		shell_exec('del /q ..\..\anim\x\*.*');
	}

	$readoffset	= $_GET['offset'] += 0;
//	$readoffset	= hexdec($readoffset);

	if ($_GET['t']) {
		$romdata	= file_get_contents("../test.gbc");
	} else {
		$romdata	= file_get_contents("../la12.gbc");
	}

	$o			= 0x98000 + $_GET['r'] * 0xA * 0x8;

	mapinit(0, 0);

	for ($i = 0; $i < 80; $i++) {

		$tile	= ord($romdata{$o});
		$y	= ($i % 10);
		$x	= floor($i / 10);
		$map[$x][$y]	= hexout($tile);
		$o++;
	}

	print exportmap($_GET['tset'], $_GET['anim'], true, $_GET['saveas'], $_GET['saveas']);

	function char2hex($char, $l = 2) {
		return str_pad(dechex(ord($char)), $l, "0", STR_PAD_LEFT);
	}

	function hexout($char, $l = 2) {
		return str_pad(dechex($char), $l, "0", STR_PAD_LEFT);
	}

	function char2dec($char) {
		return ord($char);
	}

	function mapinit($f, $t) {
		global $dungeon;
		$f	= str_pad($f, 2, "0", STR_PAD_LEFT);
		global $map;
		for ($x = 0; $x < 8; $x++) 
			for ($y = 0; $y < 10; $y++) 
				$map[$x][$y] = $f;

		if ($dungeon) {
			if ($t == "0") {	
				for ($y = 0; $y <= 7; $y++) {
					for ($x = 0; $x <= 9; $x++) {
						if($y == 0) $map[$y][$x] = "21";
						if($y == 7) $map[$y][$x] = "22";
						if($x == 0) $map[$y][$x] = "23";
						if($x == 9) $map[$y][$x] = "24";
						if($x == 0 && $y == 0) $map[$y][$x] = "25";
						if($x == 0 && $y == 7) $map[$y][$x] = "27";
						if($x == 9 && $y == 0) $map[$y][$x] = "26";
						if($x == 9 && $y == 7) $map[$y][$x] = "28";
					}
				}
			}
		}
	}

	function map3byte($x, $y, $t, $d, $l) {
		global $map, $floorcomp;
		if ($d == "|") {
			for ($x2 = 0; $x2 < $l; $x2++) {
				$x3	= $x2 + $x;
				if ($map[$x3][$y] != $floorcomp) {
					$map[$x3][$y] = hexout(hexdec($t) + 0x100);
				} else {
					$map[$x3][$y] = $t;
				}
			}
		} else {
			for ($x2 = 0; $x2 < $l; $x2++) {
				$x3	= $x2 + $y;
//				$map[$x][$x3] = $t;
				if ($map[$x][$x3] != $floorcomp) {
					$map[$x][$x3] = hexout(hexdec($t) + 0x100);
				} else {
					$map[$x][$x3] = $t;
				}
			}
		}

	}

	function map3macro($x, $y, $t, $d, $l) {
		global $map, $dungeon;
		$t2	= $t % 0x100;
		if (!$dungeon) {
			switch ($t2) {
				case 0xf5:		// tree
					$xs	= 2;
					$ys	= 2;
					break;

				case 0xf6:		// ?????
					$xs	= 5;
					$ys	= 3;
					break;

				case 0xf7:		// Big house/shop
					$xs	= 3;
					$ys	= 3;
					break;

				case 0xf8:		// catfish's maw
					$xs	= 3;
					$ys	= 2;
					break;

				case 0xf9:		// big enterance (Kanlet Castle)
					$xs	= 3;
					$ys	= 2;
					break;

				case 0xfa:		// giant pighead (map coordinate 97)
					$xs	= 2;
					$ys	= 2;
					break;

				case 0xfb:		// special tree
					$xs	= 2;
					$ys	= 2;
					break;

				case 0xfc:		// surrounded pit
					$xs	= 3;
					$ys	= 3;
					break;

				case 0xfd:		// Marin shack
					$xs	= 3;
					$ys	= 2;
					break;
			}
		} else {

			// Seems like templates aren't just 0xF_ in dungeons; 0xED is one too and so are others, I bet

			switch ($t2) {
				case 0xf0:		// slammer (top)
					$xs	= 2;
					$ys	= 1;
					break;

				case 0xf1:		// slammer (bottom)
					$xs	= 2;
					$ys	= 1;
					break;

				case 0xf2:		// slammer (left)
					$xs	= 1;
					$ys	= 2;
					break;

				case 0xf3:		// slammer (right)
					$xs	= 1;
					$ys	= 2;
					break;

			}
		}

		if ($d == "|") {
			for ($x2 = 0; $x2 < $l; $x2++) {
				$x3	= ($x2 * $xs + $x) % 0x10;
				map3macrow($x3, $y, $t, $xs, $ys);
			}
		} else {
			for ($x2 = 0; $x2 < $l; $x2++) {

				$x3	= ($x2 * $ys + $y) % 0x10;
				map3macrow($x, $x3, $t, $xs, $ys);
			}
		}
	}

	function map3macrow($x, $y, $t, $xs, $ys) {
		global $map;
//		print "Drawing x=$x, y=$y, t=$t, xs=$xs, ys=$ys<br>";
		for ($my = 0; $my < $xs; $my++) {
			$yy	= ($my + $y) % 0x10;
			for ($mx = 0; $mx < $ys; $mx++) {
				$xx	= ($mx + $x) % 0x10;
//				print "Drawing now: xx=$xx, yy=$yy<br>";
				$map[$xx][$yy] = hexout(0x100);
			}
		}
//		$map[$x][$y] = hexout($t);
		$map[$x][$y] = hexout(0x100);
	}




	function exportmap($tset = 0, $anim = 0, $final = false, $saveas = false, $redir = false) {
		global $animlookup, $map, $dungeon;
		for ($i = 0; $i < 8; $i++) {
			for ($ii = 0; $ii < 10; $ii++) {
				if (hexdec($map[$i][$ii]) >= 256 && $final) {
					$map[$i][$ii] = hexout(hexdec($map[$i][$ii]) % 256);
				}
				$str	.= ($str ? "x" : "") . $map[$i][$ii];
				if (hexdec($map[$i][$ii]) >= 256) {
					$map[$i][$ii] = hexout(hexdec($map[$i][$ii]) % 256);
				}
			}
		}
		if ($dungeon == true) {
			$qend	= "&d=1";
		} else {
			$qend	= "&s1=$tset&s2=". $animlookup[$anim];
		}
		if (!$redir) return	"<img src=\"drawer.php?n=". $str . ($saveas ? "&saveas=". $saveas : "") ."$qend\">";
		else header(		"Location:  drawer.php?n=". $str . ($saveas ? "&saveas=". $saveas : "") . $qend);

	}

?>