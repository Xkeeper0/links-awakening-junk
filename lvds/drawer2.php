<?php
 
 if ($id) {
 	require("db_connect.php");
 	$n = mysql_fetch_array(mysql_query("SELECT `leveldata` FROM `room` WHERE `id` = '$id'"));
	$n = urldecode($n[leveldata]);
 	}
 
 $n = stripslashes($n);

for($omg = 0; $omg < 80; $omg++) {
	$na[$omg] = ord($n[$omg]);
	}



$img=ImageCreate(160, 128);
$gfx=ImageCreateFromPNG("level8_r.png");  

$x = 0;
$y = 0;

for($i = 0; $i < 80; $i++){
	$thistile = $na[$i];
	
	if($thisline == 10) {
		$thisline = 0;
		$y = $y + 1;
		$x = 0;
	}
	// $thistile = hex2dec($thistile);
	$tiley = intval($thistile / 16);
	$tilex = $thistile % 16;

	if ($tilex = 11 && $tiley = 10) {
		$dark = $dark + 1;
		}

	ImageCopy($img,$gfx,$thisline*16,$y*16,$tilex*16,$tiley*16,16,16);
	$thisline = $thisline+1;

}

for ($rounds = 0; $rounds < $dark; $rounds++) {
	for ($col = 0; $col <=1; $col++) {
		$colors = imagecolorsforindex($img, $col);
		$colors[red] = $colors[red] * 0.75;
		$colors[blue] = $colors[blue] * 0.75;
		$colors[green] = $colors[green] * 0.75;
		imagecolorset($img, $col, $colors[red], $colors[blue], $colors[green]);
		}
	}

Header("Content-type:image/png");
ImagePNG($img);

imagedestroy($img);
imagedestroy($gfx);

function hex2dec($hex) {
	if ($hex == "5C0" || !$hex) $hex = "00";
	$hex = "%". $hex;
	$val = ord(urldecode($hex));
	return $val;
}
?>