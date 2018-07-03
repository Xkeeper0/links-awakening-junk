<?php
 
 if ($id) {
 	require("db_connect.php");
 	$n = mysql_fetch_array(mysql_query("SELECT `roomdata` FROM `z4rooms` WHERE `id` = '$id'"));
	$n = urldecode($n[roomdata]);
 } else {
	 $n = $_GET['n'];
 }
 $n = stripslashes($n);

for($omg = 0; $omg < 80; $omg++) {
	$na[$omg] = ord($n[$omg]);
	}

/*print "<pre><b><center>DEBUG MODE</center></b>
";
print $n ."
";
print_r( $na );*/


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

	ImageCopy($img,$gfx,$thisline*16,$y*16,$tilex*16,$tiley*16,16,16);
	$thisline = $thisline+1;

}

//ImageCopy($img,$gfx,0,0,10,10,8,8);


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