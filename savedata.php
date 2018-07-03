<?php

	$dx		= true;		// DX save? Some things change.
	$file	= min(max(intval($_GET['f']), 0), 13);			// save#.sav
	$slot	= min(max(intval($_GET['s']), 0), 2);			// Save slot (0, 1, 2)

	if ($_GET['f'] == 99) $file = 99;

	if ($file <= 0) $file	= 11;


?><style type="text/css">
	body	{
		background:		#ddd;
		font-family:	Verdana, sans-serif;
		color:			#000;
		text-align:		center;
		text-shadow:	#88d 1px 1px 3px;
		}
	table	{
		empty-cells:	hide;
		}
	td, th	{
		background:		#fff;
		border-bottom:	1px solid #777;
		border-right:	1px solid #aaa;
		padding:		2px 5px 2px 5px;
		}
	th	{
		text-align:		center;
		font-family:	Courier New, monospace;
		}
	.r	{
		text-align:		right;
		}
	.c	{
		text-align:		center;
		}
	.unk	{
		background:		#c9c9c9;
		}
	table	{
		margin-left:	auto;
		margin-right:	auto;
		}
	h1, h2, p	{
		margin:			0;
		font-family:	inherit;
		}
	a:link, a:visited	{
		color:			#00f;
		border-bottom:	1px dotted #00f;
		text-decoration:	none;
		}
	a:hover	{
		color:			#f00;
		border-bottom:	1px dotted #f00;
		text-decoration:	none;
		}
</style>
<?php




	$dat	= "Item Slot (B)|768|i
Item Slot (A)|769|i
Inventory Item|770|i
Inventory Item|771|i
Inventory Item|772|i
Inventory Item|773|i
Inventory Item|774|i
Inventory Item|775|i
Inventory Item|776|i
Inventory Item|777|i
Inventory Item|778|i
Inventory Item|779|i
Flippers|780|tf
Medicine|781|tf
Trading Item|782
Secret Seashells|783|h
Medicine Count: Found?|784
Tail Key|785|tf
Angler Key|786|tf
Face Key|787|tf
Bird Key|788|tf
Gold Leaves/Slime Key|789
L:1 Map|790|tf
L:1 Compass|791|tf
L:1 Beak|792|tf
L:1 NMKey|793|tf
L:1 Small Keys|794
L:2 Map|795|tf
L:2 Compass|796|tf
L:2 Beak|797|tf
L:2 NMKey|798|tf
L:2 Small Keys|799
L:3 Map|800|tf
L:3 Compassk|801|tf
L:3 Beak|802|tf
L:3 NMKey|803|tf
L:3 Small Keys|804
L:4 Map|805|tf
L:4 Compass|806|tf
L:4 Beak|807|tf
L:4 NMKey|808|tf
L:4 Small Keys|809
L:5 Map|810|tf
L:5 Compass|811|tf
L:5 Beak|812|tf
L:5 NMKey|813|tf
L:5 Small Keys|814
L:6 Map|815|tf
L:6 Compass|816|tf
L:6 Beak|817|tf
L:6 NMKey|818|tf
L:6 Small Keys|819
L:7 Map|820|tf
L:7 Compass|821|tf
L:7 Beak|822|tf
L:7 NMKey|823|tf
L:7 Small Keys|824
L:8 Map|825|tf
L:8 Compass|826|tf
L:8 Beak|827|tf
L:8 NMKey|828|tf
L:8 Small Keys|829
?????|830
?????|831
?????|832
?????|833
?????|834
Power Bracelet Level|835
Shield Level|836
Bow Ammo|837|h
Stealing Flag|838
Time/Animation?|839
Tarin at home flag|840
Ocarina Song List|841|b
Ocarina Song Pointer|842
Sleepy Toadstool Flag|843
Magic Powder Amount|844|h
Bomb Amount|845|h
Sword Level|846
Name|847|name
Name|848|name
Name|849|name
Name|850|name
Name|851|name
Screen you were on last|852|h
Richard Flag?|853
Bowwow Flag|854
Death Count|855
Death Count|856
?????|857
Current Health|858|hearts
Heart Containers|859
Heart Pieces|860
Rupees|861
Rupees|862
Map you're on (OW, UW1, UW2)|863|map1
Submap you're on|864|h
Screen you start on: Map|865|map2
Placement on screen (y)|866|h
Placement on screen (x)|867|h
Screen you start on: Submap|868|h
L:1 Boss Status|869|b
L:2 Boss Status|870|b
L:3 Boss Status|871|b
L:4 Boss Status|872|b
L:5 Boss Status|873|b
L:6 Boss Status|874|b
L:7 Boss Status|875|b
L:8 Boss Status|876|b
?????|877
THIEF name change flag|878|tf
L:7 Orb Screen|879
L:7 Orb x-coord|880
L:7 Orb y-coord|881
L:7 Pillar Count|882
Marin Follow Flag|883|tf
Marin Animal Village Flag|884|tf
Medicine Count: Bought|885
Magic Powder Maximum|886|h
Bomb Maximum|887|h
Arrow Maximum|888|h
Ghost Follow Flag|889|tf
Ghost HBTB Flag|890|tf
Flying Rooster Flag|891
?????|892
Goriya Item|893|item
?????|894
Honeycomb Flag|895|tf". ($dx ? "
L:0 Map|896|tf
L:0 Compass|897|tf
L:0 Beak|898|tf
L:0 NMKey|899|tf
L:0 Keys|900
L:0 Map Data|901
L:0 Map Data|902
L:0 Map Data|903
L:0 Map Data|904
L:0 Map Data|905
L:0 Map Data|906
L:0 Map Data|907
L:0 Map Data|908
L:0 Map Data|909
L:0 Map Data|910
L:0 Map Data|911
L:0 Map Data|912
L:0 Map Data|913
L:0 Map Data|914
L:0 Map Data|915
L:0 Map Data|916
L:0 Map Data|917
L:0 Map Data|918
L:0 Map Data|919
L:0 Map Data|920
L:0 Map Data|921
L:0 Map Data|922
L:0 Map Data: BLANK ROOM|923
L:0 Map Data: BLANK ROOM|924
L:0 Map Data: BLANK ROOM|925
L:0 Map Data: BLANK ROOM|926
L:0 Map Data: BLANK ROOM|927
L:0 Map Data: BLANK ROOM|928
L:0 Map Data: BLANK ROOM|929
L:0 Map Data: BLANK ROOM|930
L:0 Map Data: BLANK ROOM|931
L:0 Map Data: BLANK ROOM|932
Tunic|933|tunic
Photos|934|b
Photos|935|b" : "");


	$length	= 0x385 + 0x28 * $dx;
	$start	= 0x105;
	$rstart	= ($start + $length * $slot);
	$save	= file_get_contents("save$file.sav");
	$save	= substr($save, $rstart, $length);


	$links	= "";
	for ($i = 0; $i <= 2; $i++) {
		if ($links) $links	.= " - ";
		if ($slot != $i) {
			$links	.= "<a href='?s=$i'>Slot $i</a>";
		} else {
			$links	.= "<strong>Slot $i</strong>";
		}
	}

	print "<h1>Link's Awakening SRAM Data Display</h1>
		<h2>save$file.sav (Slot $slot, 0x". strtoupper(dechex($rstart)) .")</h2>
		<p>Offsets displayed are relative to this position</p>
		<p>$links</p>
		<br>";

	

	for ($i = 0; $i < 3; $i++) {
		print "<table><tr><th width=\"50\">". $i ."00</th><th>Map $i</th></tr><tr><td colspan=\"2\"><img src=\"savemaps.php?m=$i&s=$slot&f=$file&dx=$dx\"></td></tr></table>
				<br>";
	}

	print "<table width=640>";
	$data2	= explode("\n", $dat);
	foreach ($data2 as $data) {
		$datas		= explode("|", $data);
//		$datas[1]	= hexdec($datas[1]);
//		$roffset	= $datas[1] - $start + $length * $slot;
		$offset		= $datas[1]; // - $start;

		$valt		= ord($save{$offset});

		if ($datas[2] == "tf") {
			if ($valt) $val	= "true". ($valt > 1 ? " ($valt)" : "");
			else $val = "false";
			$datas[2]	= "flag";

		} elseif ($datas[2] == "h") {
			$val		= str_pad(strtoupper(dechex($valt)), 2, "0", STR_PAD_LEFT);
			$datas[2]	= "hex";

		} elseif ($datas[2] == "hearts") {
			$val		= $valt / 8;

		} elseif ($datas[2] == "b") {
			$val		= str_pad(decbin($valt), ($datas[3] ? $datas[3] : 8), "0", STR_PAD_LEFT);
			$datas[2]	= "binary". ($datas[3] ? " ". $datas[3] : "");

		} elseif ($datas[2] == "tunic") {
			if ($valt == 2)		$val	= "2: blue";
			elseif ($valt == 1)	$val	= "1: red";
			else				$val	= "0: green";

		} elseif ($datas[2] == "i") {
			if ($valt >= 1 && $valt <= 0xd)	$val	= "$valt: <img src=\"items/". str_pad(dechex($valt), 2, "0", STR_PAD_LEFT) .".png\">";
			elseif ($valt == 0)	$val	= "--";
			else				$val	= "$valt: ??";
			$datas[2]	= "item";

		} elseif ($datas[2] == "name") {
			if ($valt >= 1)	$val	= chr($valt - 1);
			elseif ($valt == 0)	$val	= "--";

		} elseif ($datas[2] == "map1") {
			$val		= str_pad(strtoupper(dechex($valt)), 2, "0", STR_PAD_LEFT);
			if ($val == "00") {
				$map	= "overworld/00";
			} elseif ($val == "01") {
				$map	= "underworld1/01";
			} elseif ($val == "02") {
				$map	= "underworld2/02";
			} elseif ($val == "03") {
				$map	= "underworld3/03";
			}

//			$map		= $val;
			$datas[2]	= "hex";

		} elseif ($datas[2] == "map2") {
			$val		= str_pad(strtoupper(dechex($valt)), 2, "0", STR_PAD_LEFT);
			$map		.= $val;
//			$val		= "<img src=\"http://artemis251.fobby.net/image/maps/$map.GIF\"><br>$val";
			$val		= "<div style='position: relative; float: right; padding: 0; margin: 0;'><img src=\"http://artemis251.fobby.net/zelda/maps/$map.GIF\"><div style='position: absolute; margin: 0; padding: 0; top: ". ord($save{$offset + 2}) ."px; left: ". ord($save{$offset + 1}) ."px; background: #f00; width: 16px; height: 16px;'></div></div><br style='clear: both;'>$val<br>(". dechex(ord($save{$offset + 1})) .", ". dechex(ord($save{$offset + 2})) .")<br>";
			$datas[2]	= "hex";

		} else {
			$val		= $valt;
		}

		$class	= "";
		if (strpos($datas[0], "?") !== false) $class	= " unk";

		print "<tr><th>". strtoupper(dechex($offset)) ."</td><td". ($class ? " class=\"$class\"" : "") .">". $datas[0] ."</td><td class=\"r$class\">$val</td><td class=\"c$class\">". $datas[2] ."</td></tr>\n";
	}

	print "</table>";
?>