<?php
 chdir("../extra");
 $n = stripslashes($_GET['n']);

 $n2	= explode(",", $n);

for($len = 0; $len < 80; $len++) {
	$na[$len] = $n2[$len];
	#$na[$len] = hexdec($n2[$len]);
}


$img=ImageCreateTrueColor(160, 128);

$s1	= $_GET['s1'];
$s2	= $_GET['s2'];

if ($_GET['d']) {
	$gfx=ImageCreateFromPNG("level8.png");
} else {
	include 'acmlm/tiles2.php';
}



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
	if ($thistile >= 1024) {
		$thistile	-= 1024;
		$over3		= true;
	} elseif ($thistile >= 512) {
		$thistile	-= 512;
		$over2		= true;
	} elseif ($thistile >= 256) {
		$thistile	-= 256;
		$over		= true;
	}
	$tiley = intval($thistile / 16);
	$tilex = $thistile % 16;

	ImageCopy($img,$gfx,$thisline*16,$y*16,$tilex*16,$tiley*16,16,16);
	if ($over2) ImageFilledRectangle($img,$thisline*16,$y*16,$thisline*16+15,$y*16+15,imagecolorallocatealpha($img, 0, 255, 0, 70));
	if ($over) ImageFilledRectangle($img,$thisline*16,$y*16,$thisline*16+15,$y*16+15,imagecolorallocatealpha($img, 255, 255, 0, 70));
	if ($over3) ImageFilledRectangle($img,$thisline*16,$y*16,$thisline*16+15,$y*16+15,imagecolorallocatealpha($img, 0, 0, 255, 100));
	//if ($thistile == 0x00) ImageFilledRectangle($img,$thisline*16,$y*16,$thisline*16+15,$y*16+15,imagecolorallocatealpha($img, 128, 0, 0, 80));
	$over	= false;
	$over2	= false;
	$over3	= false;
	$thisline = $thisline+1;

}

//ImageCopy($img,$gfx,0,0,10,10,8,8);


Header("Content-type:image/png");
ImagePNG($img);
if ($_GET['saveas']) {
	ImagePNG($img, "drawn/". str_pad($_GET['saveas'], 2, "0", STR_PAD_LEFT) .".png");
}

imagedestroy($img);
imagedestroy($gfx);

function hex2dec($hex) {
	if ($hex == "5C0" || !$hex) $hex = "00";
	$hex = "%". $hex;
	$val = ord(urldecode($hex));
	return $val;
}
