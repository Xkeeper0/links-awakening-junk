<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>Zelda 4 Room Designer</title>
	<link rel="stylesheet" href="z4rd.css" type="text/css">
</head>

<body>

<?php

for ($y = 0; $y <= 7; $y++) {
	for ($x = 0; $x <= 9; $x++) {
		$tile[$x][$y] = str_pad($_POST["tile". $x ."_". $y], 2, "0D", STR_PAD_LEFT);
		if ($_POST[template] >= 1) {
			if($y == 0) $tile[$x][$y] = "21";
			if($y == 7) $tile[$x][$y] = "22";
			if($x == 0) $tile[$x][$y] = "23";
			if($x == 9) $tile[$x][$y] = "24";
			if($x == 0 && $y == 0) $tile[$x][$y] = "25";
			if($x == 0 && $y == 7) $tile[$x][$y] = "27";
			if($x == 9 && $y == 0) $tile[$x][$y] = "26";
			if($x == 9 && $y == 7) $tile[$x][$y] = "28";
		}
	}
}

if ($_POST[template] == 2) {
	$tile[3][5] = "B3";
	$tile[4][5] = "B4";
	$tile[5][5] = "B4";
	$tile[6][5] = "B5";
	$tile[3][6] = "B6";
	$tile[4][6] = "B7";
	$tile[5][6] = "B8";
	$tile[6][6] = "B9";
	$tile[3][7] = "BA";
	$tile[4][7] = "BB";
	$tile[5][7] = "BC";
	$tile[6][7] = "BD";
	}

for ($y = 0; $y <= 7; $y++) {
	for ($x = 0; $x <= 9; $x++) {
		$level = $level . "%". $tile[$x][$y];
	}
}


print "<form action=\"index.php\" method=\"post\">
<table align=center>
<tr><td colspan=2 height=16 class=\"head\" align=center><img src=\"images/z4rd.gif\" alt=\"Zelda 4 Room Designer\" height=10></td></tr>
<tr><td height=16 class=\"minihead\" align=center><img src=\"images/tileset.gif\" alt=\"Tileset\" height=10></td><td height=16 class=\"minihead\" align=center><img src=\"images/Layout.gif\" alt=\"Layout\" height=10></td>
<tr><td width=0 rowspan=3 class=\"tileset\"><img src=tlist_8.png alt=\"tileset\"></td><td>
";

for ($y = 0; $y < 8; $y++) {
	for ($x = 0; $x < 10; $x++) {
		print "<input type=text size=2 maxlength=2 name=\"tile". $x ."_". $y ."\" value=\"". $tile[$x][$y] ."\">";
		$level = $level . "%". $tile[$x][$y];
	}
	print "<br>";
}

print "
</td></tr>
<tr><td height=16 class=\"minihead\" align=center><img src=\"images/options.gif\" alt=\"Options\" height=10></td></tr>
<tr><td valign=top>

Template: 
<input type=radio name=template value=0 class=\"radio\" checked>None 
<input type=radio name=template value=1 class=\"radio\"><img src=\"images/temp_fullwall.png\" alt=\"full walls\" title=\"4 Walls\">
<input type=radio name=template value=2 class=\"radio\"><img src=\"images/temp_entrance.png\" alt=\"entrance\" title=\"Dungeon Entrance\">
<br><br><br><center><input type=submit name=Submit value=\"Draw!\"></center>
</td></tr>


<tr><td height=16 class=\"head\" align=center colspan=2><img src=\"images/preview.gif\" alt=\"Preview\" height=10></td></tr>
<tr><td colspan=2 align=center class=preview>

<br><img src=\"drawer.php?n=". $level ."\" alt=\"preview\">
<br><a href=\"drawer.php?n=". $level ."\">Copy this link URL to send to a friend!</a>
<br>&nbsp;

</td></tr></table>
</form>

</body>
</html>";

?>