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

	$readoffset	= hexdec($_GET['offset']);

	if ($_GET['t']) {
		$romdata	= file_get_contents("../test.gbc");
	} else {
		$romdata	= file_get_contents("../la12.gbc");
	}

	$base['roomtemplates']	= 0x050881;

	for ($i	= 0; $i <= 0x08; $i++) {
		$p	= $base['roomtemplates'] + $i * 2;
		$pointer['roomtemplates'][$i]['l']	= array(ord($romdata{$p}), ord($romdata{$p + 1}));
		$offset['roomtemplates'][$i]['l']	= point2loc($base['roomtemplates'], $pointer['roomtemplates'][$i]['l'][0], $pointer['roomtemplates'][$i]['l'][1]);

		$p	= $offset['roomtemplates'][$i]['l'] + 5;
		$pointer['roomtemplates'][$i]['p']	= array(ord($romdata{$p}), ord($romdata{$p + 1}));
		$p	= $offset['roomtemplates'][$i]['l'] + 8;
		$pointer['roomtemplates'][$i]['t']	= array(ord($romdata{$p}), ord($romdata{$p + 1}));

		$offset['roomtemplates'][$i]['p']	= point2loc($base['roomtemplates'], $pointer['roomtemplates'][$i]['p'][0], $pointer['roomtemplates'][$i]['p'][1]);
		$offset['roomtemplates'][$i]['t']	= point2loc($base['roomtemplates'], $pointer['roomtemplates'][$i]['t'][0], $pointer['roomtemplates'][$i]['t'][1]);

	}



	$o			= $readoffset;
	$animation	= ord($romdata[$o]);
	$o++;
	$tempfloor	= char2dec($romdata[$o]);
	if ($o >= 164352 && $o <= 0x30000) {
		$template	= dechex(floor($tempfloor / 16));
		$floor		= hexout($tempfloor % 16);
		$dungeon	= true;
	} else {
		$template	= 9;
		$floor		= hexout($tempfloor);
		$dungeon	= false;
	}

	$floorcomp	= hexout($tempfloor);

	if ($_GET['forcefloor']) {
		$floor	= $_GET['forcefloor'];
	}
	mapinit($floor, $template);

	// nothing?, <number>, B2B00, B2C00, B2D00, B2E00, B2F00, B2D00 (plus something else I haven't found yet), B3000, B3100, B3200, B2A00, B3300, B3500, B3600, B3400, B3700

	$animlookup	= array(
		0x00	=> 0,
		0x01	=> 0x0,
		0x02	=> 0x1,
		0x03	=> 0x2,  // 2?
		0x04	=> 0x3,
		0x05	=> 0x4,
		0x06	=> 0x5,
		0x07	=> 0x3,
		0x08	=> 0x6,
		0x09	=> 0x7,
		0x0a	=> 0x8,
		0x0b	=> 0x0,
		0x0c	=> 0x9,
		0x0d	=> 0xB,
		0x0e	=> 0xC,
		0x0f	=> 0xA,
		0x10	=> 0xD,
		);

	if (!$_GET['saveas']) {
		print "<b>Attempting to read level data from <font color=ffa0a0>". $_GET['offset'] ."</font> ...</b>

<b>Warning: Does not take into account
- Templates
- Animation
- \"Special\" objects (doors, enterances)
- Graphics or palette types</b>

Animation:      <font color=ffa0a0>". hexout($animation) ."</font>
Room template:  <font color=ffa0a0>$template</font> (". hexout($tempfloor) .")
Floor tile:     <font color=ffa0a0>$floor". ($_GET['forcefloor'] ? " (override: ". $_GET['forcefloor'] .")" : "") ."</font>

<font color=ddddff><b>Decoding level...</b></font>
<table><tr class=head><td>#</td><td>y</td><td>x</td><td>tile</td><td>dir / len</td><td>raw</td><td>img</td></tr>\n";
	}
	$wn	= 0;
	$objnum	= 0;
		$o++;
		$read	= char2dec($romdata[$o]);
		if ($read == 254) $end = true;
	while (!$end) {
		$et	= "";
		$noimg	= false;
		if (!$_GET['saveas']) print "<tr>";
	// <128 = two-byte object
/*		if ($read == 0xf9 || $read == 0xf8) {
			$skip	= $read;
			$o++;
			$read	= char2dec($romdata[$o]);
			if (dechex($read) == "fe") $end = true;
			print "<font color=#ff8080>Skipped byte: ". hexout($skip) ."</font>\n";
		}
		if ($read < 128) {
*/		if ($read < 128 || $read >= 0xF0) {
			$r	= char2hex($romdata[$o]);
			$x	= floor($read / 16);
			$y	= $read % 16;

			$o++;
			$tile	= ord($romdata[$o]);
			$r	.= " ". char2hex($romdata[$o]);
			if ($tile < 0xF0) {
				if ($map[$x][$y] != $floorcomp) {
					$map[$x][$y]	= hexout($tile + 0x200);
				} else {
					$map[$x][$y]	= hexout($tile + 0x100);
				}
			} else {
				map3macro($x, $y, $tile + 0x100, "-", 1);
			}

			$objnum++;
			if ($y > 0x9 || $x > 0x7) $et	= "<font color=#ff8080>Invalid?</font>";
			if (!$_GET['saveas']) print "<td><a name=\"$objnum\" href=\"#$objnum\">$objnum</a></td><td>". hexout($x, 1) ."</td><td>". hexout($y, 1) ."</td><td>". hexout($tile) ."</td><td>&nbsp;</td><td>$r $et</td>";

	// 5-byte warp data
		} elseif (floor($read / 16) == 0xE) {
			if (!$_GET['saveas']) print "<td colspan=6>5-byte warp data found</td>";
			$noimg	= true;
			$warp[$wn][0]	= char2hex($romdata[$o]);
			$warp[$wn][1]	= char2hex($romdata[$o+1]);
			$warp[$wn][2]	= char2hex($romdata[$o+2]);
			$warp[$wn][3]	= char2hex($romdata[$o+3]);
			$warp[$wn][4]	= char2hex($romdata[$o+4]);
			$wn++;
			$o	+= 4;	// advance
//			$end	= true;
		} elseif (dechex($read) != "fe") {
			$r	= char2hex($romdata[$o]);
			$d	= floor($read / 16);
			$l	= ($read % 16);
			$d2	= $d;
			if ($d == 8) $d = "-";
			else $d = "|";

			$o++;
			$read	= char2dec($romdata[$o]);
			$x	= floor($read / 16);
			$y	= $read % 16;
			$r	.= " ". char2hex($romdata[$o]);

			$o++;
			$tile	= ord($romdata[$o]);
			$objnum++;
			$r	.= " ". char2hex($romdata[$o]);

//			if ($d2	== 15) $end	= true;

			if ($y > 0x9 || $x > 0x7 || ($d2 != 8 && $d2 != 12) || $l > 0xA) $et	= "<font color=#ff8080>Invalid?</font>";
			if (!$_GET['saveas']) print "<td><a name=\"$objnum\" href=\"#$objnum\">$objnum</a></td><td>". hexout($x, 1) ."</td><td>". hexout($y, 1) ."</td><td>". hexout($tile) ."</td><td>$d ". hexout($d2) .", $l</td><td>$r $et</td>";

			if ($tile < 0xF0) {
				map3byte($x, $y, hexout($tile + 0x100), $d, $l);
			} else {
				map3macro($x, $y, $tile + 0x100, $d, $l);
			}
		}
		$o++;
		$read	= char2dec($romdata[$o]);
		if (!$_GET['saveas']) print "<td>". (!$_GET['noimg'] ? "&nbsp;" : exportmap($_GET['tset'], $animation, false, ($_GET['saveall'] ? ($_GET['anim'] ? "../../../anim/x/" : "") ."r". str_pad($objnum, 3, "0", STR_PAD_LEFT) : false))) ."</td></tr>\n\n";

		if (dechex($read) == "fe") $end = true;


	}

	$bytes = $o - $readoffset + 1;
	if (!$_GET['saveas']) print "</table>------------\n<font color=ffa0a0><b>End of level data (<font color=ffd0d0>$bytes</font> bytes used)</b></font>";

	if ($warp && !$_GET['saveas']) {
		print "\nWarp data:
Type  Submap  Screen  PixelX  PixelY  ???? 1  ???? 2<font color=80ff80>
";
		foreach($warp as $warpd) {
			print "  ". $warpd[0] ."      ". $warpd[1] ."      ". $warpd[2] ."      ". $warpd[3] ."      ". $warpd[4] ."      ". $warpd[5] ."      ". $warpd[6] ."\n";
		}
		print "</font>";
	}

	if (!$_GET['saveas']) print "\n\nLayout:\n";

	if ($_GET['anim']) {
		print "<a href=/anim/ranim.php?name=". $_GET['saveall'] .">Animate!</a><br><br>";
		$objnum++;
		print exportmap($_GET['tset'], $animation, false, ($_GET['saveall'] ? ($_GET['anim'] ? "../../../anim/x/" : "") ."r". str_pad($objnum, 3, "0", STR_PAD_LEFT) : false));
	} else {
		print exportmap($_GET['tset'], $animation, true, $_GET['saveas'], $_GET['saveas']);
	}

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
			if ($t < 9) {
				global $offset;
				$map	= parsetemplate($offset['roomtemplates'][$t]['p'], $offset['roomtemplates'][$t]['t'], $map);
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

				case 0xf6:		// big house north of rooster
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


	function parsetemplate($offset1, $offset2, $room) {
		global $romdata;

		printf("Happy template parser! Given offsets [%06x] and [%06x]<br><br>", $offset1, $offset2);

		$rc		= 0;

		while (ord($romdata{$offset1 + $rc}) != 0xFF && $rc <= 80) {
			$val		= ord($romdata{$offset1 + $rc});
			$y			= ($val & 0xF0) >> 4;
			$x			= $val & 0x0F;
			$pos[$rc]	= array($y, $x);
			$o++;
			$rc++;
		}

		for($i = 0; $i <= $rc; $i++) {
			$val		= ord($romdata{$offset2 + $i});
			if ($val)
				$room[$pos[$i][0]][$pos[$i][1]]	= sprintf("%02x", $val);
		}

		return $room;
	}

	function point2loc($base, $pointer1, $pointer2) {

		$base	= floor($base / 0x4000) * 0x4000;

		return $base + $pointer1 + (($pointer2 - 0x40) << 8);

	}
