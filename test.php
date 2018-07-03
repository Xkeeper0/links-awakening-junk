<title>xkeeper's links awakening mess</title>
<style type="text/css">
	body {
		font-family:		Courier New, monospace;
		color:				#000;
		background:			#fff;
}
	table {
		border:				1px solid #888;
		border-collapse:	collapse;
	}
	td {
		border:				1px solid #888;
		padding:			1px 3px 1px 3px;
		background:			#fff;
	}
	th {
		border:				1px solid #888;
		padding:			1px 6px 1px 12px;
		background:			#fff;
	}
	a:link	{
		color:	#008;
		background:	#ccf;
		}
	a:visited	{
		color:	#608;
		background:	#fcf;
		}
</style>
<?php

	$ip				= "192.168.1.200";

//	ini_set("memory_limit", "256M");

	$fname	= "ladx-g.gbc";
	$rom	= file_get_contents($fname);

	$base['roommap']		= 0x050220;
	$base['minimap']		= 0x00A49A;
	$base['pointers'][0]	= 0x024000;
	$base['pointers2'][0]	= 0x068000;
	$base['pointers'][1]	= 0x028000;
	$base['pointers'][2]	= 0x02C000;
	$base['pointers'][3]	= 0x02BB77;
	$num['pointers'][3]		= 0x1F;
	$base['roomtemplates']	= 0x050881;
	$base['tilesets']		= 0x082E7B;
	$base['chests'][0]		= 0x050560;
	$base['chests'][1]		= 0x050660;
	$base['chests'][2]		= 0x050760;
	$base['chests'][3]		= 0x050860;
	$base['events'][1]		= 0x050000;
	$base['events'][2]		= 0x050100;
	$base['sprites'][0]		= 0x058000;
	$base['sprites'][1]		= 0x058200; // ?
	$base['sprites'][2]		= 0x058400; // ?
	$base['sprites'][3]		= 0x058600; // ?

	for ($i	= 0; $i <= 15; $i++) {
		$offset['roommap'][$i]	= $base['roommap'] + $i * 64;
		$offset['minimap'][$i]	= $base['minimap'] + $i * 64;
	}

	for ($b	= 0; $b <= 3; $b++) {
		$max	= ($num['pointers'][$b] ? $num['pointers'][$b] : 0xFF);
		for ($i	= 0; $i <= $max; $i++) {
			$p	= $base['pointers'][$b] + $i * 2;
			$pointer['room'][$b][$i]	= array(ord($rom{$p}), ord($rom{$p + 1}));
			if ($b == 0 && $i >= 0x80) {
				$offset['room'][$b][$i]	= point2loc($base['pointers2'][$b], $pointer['room'][$b][$i][0], $pointer['room'][$b][$i][1]);
			} else {
				$offset['room'][$b][$i]	= point2loc($base['pointers'][$b], $pointer['room'][$b][$i][0], $pointer['room'][$b][$i][1]);
			}
			if ($b == 0) {
				$o		= floor($i * .5) % 8 + floor($i / 32) * 8 + $base['tilesets'];
				$tileset[$b][$i]	= (ord($rom{$o}) - 0x1a) / 2;
			}

		}
	}


	for ($b	= 0; $b <= 3; $b++) {
		for ($i	= 0; $i <= 0xFF; $i++) {
			$p	= $base['sprites'][$b] + $i * 2;
			$pointer['sprites'][$b][$i]	= array(ord($rom{$p}), ord($rom{$p + 1}));
//			if ($b == 0 && $i >= 0x80) {
//				$offset['sprites'][$b][$i]	= point2loc($base['pointers2'][$b], $pointer['sprites'][$b][$i][0], $pointer['sprites'][$b][$i][1]);
//			} else {
			$offset['sprites'][$b][$i]	= point2loc($base['sprites'][$b], $pointer['sprites'][$b][$i][0], $pointer['sprites'][$b][$i][1]);
//			}
		}
	}


	for ($i	= 0; $i <= 0x08; $i++) {
		$p	= $base['roomtemplates'] + $i * 2;
		$pointer['roomtemplates'][$i]['l']	= array(ord($rom{$p}), ord($rom{$p + 1}));
		$offset['roomtemplates'][$i]['l']	= point2loc($base['roomtemplates'], $pointer['roomtemplates'][$i]['l'][0], $pointer['roomtemplates'][$i]['l'][1]);

		$p	= $offset['roomtemplates'][$i]['l'] + 5;
		$pointer['roomtemplates'][$i]['p']	= array(ord($rom{$p}), ord($rom{$p + 1}));
		$p	= $offset['roomtemplates'][$i]['l'] + 8;
		$pointer['roomtemplates'][$i]['t']	= array(ord($rom{$p}), ord($rom{$p + 1}));

		$offset['roomtemplates'][$i]['p']	= point2loc($base['roomtemplates'], $pointer['roomtemplates'][$i]['p'][0], $pointer['roomtemplates'][$i]['p'][1]);
		$offset['roomtemplates'][$i]['t']	= point2loc($base['roomtemplates'], $pointer['roomtemplates'][$i]['t'][0], $pointer['roomtemplates'][$i]['t'][1]);

	}

	for ($i = 0; $i <= 2; $i++) {
		for ($i2 = 0; $i2 <= 0xFF; $i2++) {
			$o	= $base['chests'][$i] + $i2;
			$chests[$i][$i2]	= ord($rom{$o});
		}
	}


//	print roomlayout( 0);
/*
	print "<table>";
	for ($i = 0; $i < 768; $i++) {
		$o		= $base['tilesets'] + $i * 2;
		$b1		= ord($rom{$o});
		$b2		= ord($rom{$o + 1});

		$x1		= ($b1 >> 2) | ($b2 & 0xF0) >> 4;
		$x2		= $b2 & 0x0F;
		$da[$i][0]	= $x1;
		$da[$i][1]	= $x2;
		print "<tr><th>$i</th>
			<td>". hexout($b1) ." ". hexout($b2) ."</td>
			<td>". str_pad(decbin($b1), 8, "0", STR_PAD_LEFT) ." ". str_pad(decbin($b2), 8, "0", STR_PAD_LEFT) ."</td>
			<td>". hexout($x1) ." ". hexout($x2) ."</td>
			<td>". str_pad(decbin($x1), 8, "0", STR_PAD_LEFT) ." ". str_pad(decbin($x2), 8, "0", STR_PAD_LEFT) ."</td>
			</tr>";
	}
	print "</table>";

	print "<br><br>";

	print "<table>";
	for ($i = 0; $i < 768; $i++) {
		if (!($i % 256)) print "<tr><td colspan=32>a</td></tr>";
		if (!($i % 16)) print "<tr>";
		$c1	= "FF". str_repeat(hexout(ceil($da[$i][0] / 0x16 * 255)), 2);
		$c2	= str_repeat(hexout(ceil($da[$i][1] / 0xF * 255)), 1) ."FF". str_repeat(hexout(ceil($da[$i][1] / 0xF * 255)), 1);

		print "<td style=\"background: #$c1\">". hexout($da[$i][0]) ."</td><td style=\"background: #$c2\">". hexout($da[$i][1]) ."</td>";
//		if (!($i + 1) % 16) print "</tr>";
	}
	print "</table>";
*/

	echo "<table>
		<tr><td>". roomlayout( 0) ."</td><td>". minimap( 0) ."</td></tr>
		<tr><td>". roomlayout( 1) ."</td><td>". minimap( 1) ."</td></tr>
		<tr><td>". roomlayout( 2) ."</td><td>". minimap( 2) ."</td></tr>
		<tr><td>". roomlayout( 3) ."</td><td>". minimap( 3) ."</td></tr>
		<tr><td>". roomlayout( 4) ."</td><td>". minimap( 4) ."</td></tr>
		<tr><td>". roomlayout( 5) ."</td><td>". minimap( 5) ."</td></tr>
		<tr><td>". roomlayout( 6) ."</td><td>". minimap( 6) ."</td></tr>
		<tr><td>". roomlayout( 7) ."</td><td>". minimap( 7) ."</td></tr>
		<tr><td>". roomlayout( 8) ."</td><td style=\"background: #666;\">&nbsp;</td></tr>
		<tr><td>". roomlayout( 9) ."</td><td style=\"background: #666;\">&nbsp;</td></tr>
		<tr><td>". roomlayout(10) ."</td><td style=\"background: #666;\">&nbsp;</td></tr>
		<tr><td>". roomlayout(11) ."</td><td>". minimap( 9) ."</td></tr>
		<tr><td>". roomlayout(12) ."</td><td>". minimap( 8) ."</td></tr>
		</table><br><br>";

	print roomlayout(10);

/*
	print "<br><br><table><tr>";

	for ($i = 0; $i <= 2; $i++) {
		print "<td valign=top><table><tr><td colspan=2>Chests - bank $i</td></tr>";
		for ($i2 = 0; $i2 <= 0xFF; $i2++) {
			if ($chests[$i][$i2]) print "\n<tr><td>". hexout($i2) ."</td><td>". hexout($chests[$i][$i2]) ."</td></tr>";
		}
		print "</table></td>";
	}

	print "</tr></table>";
*/

	print "<br><br><br>";

	for ($b	= 0; $b <= 3; $b++) {

		print "<table>
		<td colspan=16 style=\"background: #aaf; text-align: center;\"><b>bank - $b - pointers</b></td><tr>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		";

		$max	= ($num['pointers'][$b] ? $num['pointers'][$b] : 0xFF);
		for ($i	= 0; $i <= $max; $i++) {
			if (!($i % 4)) echo "<tr>";
			if ($b == 0 && $_SERVER['REMOTE_ADDR'] == $ip) {
				$simg	= "<img src=\"extra/loader.php?offset=0x". dechex($offset['room'][$b][$i]) ."&saveas=". dechex($i) ."&tset=". $tileset[$b][$i] ."\">";
				if (!$_GET['uhoh']) $simg	= "
					<a href=\"extra/loader.php?offset=0x". dechex($offset['room'][$b][$i]) ."&tset=". $tileset[$b][$i] ."&saveall=". hexout($i) ."&anim=1&noimg=1\">A</a>
					<a href=\"extra/loader.php?offset=0x". dechex($offset['room'][$b][$i]) ."&tset=". $tileset[$b][$i] ."&saveas=". dechex($i) ."\">S</a>
					";
			} else {
				$simg	= "&nbsp;";
			}
			if ($offset['room'][$b][$i + 1]) {
				$dist	= str_replace(" ", "&nbsp;", sprintf("%4d", $offset['room'][$b][$i + 1] - $offset['room'][$b][$i]));
			} else {
				$dist	= "----";
			}
			echo "<th>". str_pad(dechex($i), 2, "0", STR_PAD_LEFT) ."</th><td>
			". str_pad(dechex($pointer['room'][$b][$i][0]), 2, "0", STR_PAD_LEFT) ." 
			". str_pad(dechex($pointer['room'][$b][$i][1]), 2, "0", STR_PAD_LEFT) ."</td>
			<td><a href=\"extra/loader.php?offset=0x". dechex($offset['room'][$b][$i]) ."&tset=". $tileset[$b][$i] ."\">". str_pad(dechex($offset['room'][$b][$i]), 6, "0", STR_PAD_LEFT) ."</a> $dist". (true || $_SERVER['REMOTE_ADDR'] == $ip ? " <a href=\"extra/loader.php?offset=0x". dechex($offset['room'][$b][$i]) ."&tset=". $tileset[$b][$i] ."&noimg=1\">I</a>" : "") ."
</td><td style=\"background: #ddd; text-align: center;\">$simg</td>
	";
		}

		print "</table><br><br>";
	
	}



	for ($b	= 0; $b <= 3; $b++) {

		print "<table>
		<td colspan=16 style=\"background: #aaf; text-align: center;\"><b>enemies / bank - $b - pointers</b></td><tr>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		<td style=\"background: #99c; text-align: center;\">&nbsp;</td>
		";

		for ($i	= 0; $i <= 0xFF; $i++) {
			if (!($i % 4)) echo "<tr>";

			echo "<th>". str_pad(dechex($i), 2, "0", STR_PAD_LEFT) ."</th><td>
			". str_pad(dechex($pointer['sprites'][$b][$i][0]), 2, "0", STR_PAD_LEFT) ." 
			". str_pad(dechex($pointer['sprites'][$b][$i][1]), 2, "0", STR_PAD_LEFT) ."</td>
			<td>
			<a href=\"enemies.php?offset=0x". dechex($offset['sprites'][$b][$i]) ."&room=". hexout($i) ."&m=$b\">". str_pad(dechex($offset['sprites'][$b][$i]), 6, "0", STR_PAD_LEFT) ."</a>
			</td><td style=\"background: #ddd; text-align: center;\">&nbsp;</td>
	";
		}

		print "</table><br><br>";
	
	}


//	/* 
	$ptypes	= array("l", "p", "t");
	print "<table><tr><td colspan=3 style=\"background: #88d; text-align: center;\"><b>template pointers</b></td><tr>";
	foreach ($ptypes as $t) {

		print "<td style=\"padding: 1px 10px 1px 10px; background: #88a;\"><table>
		<td colspan=3 style=\"background: #aaf; text-align: center;\"><b>pointer $t</b></td><tr>
		<td style=\"background: #ccf; text-align: center;\"><b>#</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>ptr</b></td>
		<td style=\"background: #ccf; text-align: center;\"><b>rom</b></td>
		";

		for ($i	= 0; $i <= 0x8; $i++) {
			echo "<tr><td>". str_pad(dechex($i), 2, "0", STR_PAD_LEFT) ."</td><td>
			". str_pad(dechex($pointer['roomtemplates'][$i][$t][0]), 2, "0", STR_PAD_LEFT) ." 
			". str_pad(dechex($pointer['roomtemplates'][$i][$t][1]), 2, "0", STR_PAD_LEFT) ."</td>
			<td>". str_pad(dechex($offset['roomtemplates'][$i][$t]), 6, "0", STR_PAD_LEFT) ."</td>
		";
		}
		print "</table></td>";
	}
	print "</table><br>";


	for ($i	= 0; $i <= 8; $i++) {
		$room	= initroom(0x00);
		print "<table>
			<tr><td colspan=10 style=\"background: #ccf;\"><b>Template $i</b></td></tr>";

		$room	= parsetemplate($offset['roomtemplates'][$i]['p'], $offset['roomtemplates'][$i]['t'], $room);
		for ($y = 0; $y <= 7; $y++) {
			print "<tr>";
			for ($x = 0; $x <= 9; $x++) {
				$style	= " style=\"padding: 0; border: none;\"";
				if ($room[$y][$x] == 0x00) $style	= " style=\"padding: 0; border: none; background: #888\"";
				print "<td$style><img src=\"i/". hexout($room[$y][$x], 2) .".png\"></td>";
			}
			print "</tr>";
		}
		print "</table><br>";
	}
//	*/

	function roomlayout($num, $base = 0, $big = false) {

		global $offset, $rom;
		if ($num != -1) $base	= $offset['roommap'][$num];

		$ret	.= "<table><td colspan=8 style=\"background: #aaf; text-align: center;\"><b>layout ". ($num != -1 ? "$num - " : "") ." ". dechex($base) ."</b></td><tr>";
		for ($r = 0; $r < 64; $r++) {
			
			if (!($r % 8)) $ret	.= "<tr>";

			$ofs	= $base + $r;
			$data	= ord($rom{$ofs});		// cheep

			$style	= "";
			if ($data == 0) $style	= " style=\"background: #888\"";
			if ($big) {
//				$ret	.= "<td><img src=\"http://artemis251.fobby.net/image/maps/underworld2/02". strtoupper(str_pad(dechex($data), 2, "0", STR_PAD_LEFT)) .".GIF\"></td>";
				$ret	.= "<td><img src=\"extra/drawn/". strtoupper(str_pad(dechex($data), 2, "0", STR_PAD_LEFT)) .".png\"></td>";
			} else {
				$ret	.= "<td$style>". str_pad(dechex($data), 2, "0", STR_PAD_LEFT) ."</td>";
			}


		}

		$ret	.= "</td></table>";
		return $ret;
	}



	function minimap($num, $base = 0) {

		global $offset, $rom;
		if ($num != -1) $base	= $offset['minimap'][$num];

		$ret	.= "<table><td colspan=8 style=\"background: #aaf; text-align: center;\"><b>minimap ". ($num != -1 ? "$num - " : "") ." ". dechex($base) ."</b></td><tr>";
		for ($r = 0; $r < 64; $r++) {
			
			if (!($r % 8)) $ret	.= "<tr>";

			$ofs	= $base + $r;
			$data	= ord($rom{$ofs});		// cheep

			$style	= " style=\"background: #fff\"";
			if ($data == 0x7d) $style	= " style=\"background: #888\"";
			if ($data == 0xee) $style	= " style=\"background: #fbb\"";
			if ($data == 0xed) $style	= " style=\"background: #ed9\"";
			$ret	.= "<td$style>". str_pad(dechex($data), 2, "0", STR_PAD_LEFT) ."</td>";

		}

		$ret	.= "</td></table>";
		return $ret;
	}


	function point2loc($base, $pointer1, $pointer2) {

		$base	= floor($base / 0x4000) * 0x4000;

		return $base + $pointer1 + (($pointer2 - 0x40) << 8);

	}
		
	function initroom($floor) {

		return array_fill(0, 8, array_fill(0, 10, $floor));

	}

	
	function parsetemplate($offset1, $offset2, $room) {
		global $rom;

		$rc		= 0;
	
		while (ord($rom{$offset1 + $rc}) != 0xFF && $rc <= 80) {
			$val		= ord($rom{$offset1 + $rc});
			$y			= ($val & 0xF0) >> 4;
			$x			= $val & 0x0F;
			$pos[$rc]	= array($y, $x);
			$o++;
			$rc++;
		}

		for($i = 0; $i <= $rc; $i++) {
			$val		= ord($rom{$offset2 + $i});
			$room[$pos[$i][0]][$pos[$i][1]]	= $val;
		}
		
		return $room;
	}


	function hexout($v, $l = 2) {
		return str_pad(strtoupper(dechex($v)), $l, "0", STR_PAD_LEFT);
	}

?>
