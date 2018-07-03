<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>Some broken utility that doesn't work</title>
	<style type="text/css">
		input {
			border:		#000000 solid 1px;
			background:	#E0E0E0;
			color:		#000000;
			font:		8pt Verdana;
			text-align:	center;
			}
		td {
			font:		8pt Verdana;
			border:		#000000 solid 1px;
			background:	#FFFFFF;
			}
		table {
			border:		#000000 solid 1px;
			border-collapse: collapse;
			}
		.preview {
			background:	url("trans.gif");
			}
		body {
			background:	#EEEEEE url("bg.png");
			font:		8pt Verdana;
			color:		#000000;
			}
		.preview a {
			color:		#FFFFFF;
			}
	</style>
</head>

<body>

<?php

for ($y = 0; $y <= 7; $y++) {
	for ($x = 0; $x <= 9; $x++) {
		$tile[$x][$y] = str_pad($_POST["tile". $x ."_". $y], 2, "0D", STR_PAD_LEFT);
	}
}

print "<form action=\"utility.php\" method=\"post\">
<table align=center>
<tr><td colspan=2 align=center><big><b>Zelda 4 Level Designer</b></big></td></tr>
<tr><td width=0><img src=tlist_8.png alt=\"tileset\"></td><td>
";

for ($y = 0; $y < 8; $y++) {
	for ($x = 0; $x < 16; $x++) {
		print "<input type=text size=2 maxlength=2 name=\"tile". $x ."_". $y ."\" value=\"". $tile[$x][$y] ."\">";
		$level = $level . "%". $tile[$x][$y];
	}
	print "<br>";
}

print "<br><center><input type=submit name=asdf value=\"Draw!\"></center>

</td></tr>
<tr><td colspan=2 align=center class=preview height=150>

<br><img src=\"drawer.php?n=". $level ."\" alt=\"preview\">
<br><a href=\"drawer.php?n=". $level ."\">Copy this link URL to send to a friend!</a>
<br>&nbsp;

</td></tr></table>
</form>

</body>
</html>";

?>