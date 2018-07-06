<?php
// Header('Content-type:image/png');

// foreach($_GET as $k=>$v) {
//	 $$k = $v;
// }

 $gfx=ImageCreate(256,256);
 ImageColorAllocate($gfx,50,50,220);
 if($b){
   $tiles=ImageCreate(128,128);
   ImageColorAllocate($tiles,90,82,255);
 }else
   $tiles=ImageCreateFromPNG('acmlm/tiles.png');
 $sets1=ImageCreateFromPNG('acmlm/sets1.png');
 $sets2=ImageCreateFromPNG('acmlm/sets2.png');

 if($s1>=0 && $s1<20)
   ImageCopy($tiles,$sets1,0,0,0,$s1*16,128,16);
 if($s2>=0 && $s2<16)
   ImageCopy($tiles,$sets2,96,48,0,$s2*8,32,8);

 $f=fopen('acmlm/tiles.dat','r');
 $data=fread($f,1024);
 fclose($f);

 for($x=0;$x<256;$x++){
   $px=($x%16)*16;
   $py=floor($x/16)*16;
   for($k=0;$k<4;$k++){
     $t=ord($data[$x*4+$k]);
     ImageCopy($gfx,$tiles,$px+($k%2)*8,$py+floor($k/2)*8,($t%16)*8,floor($t/16)*8,8,8);
   }
 }

// ImagePNG($gfx);
// ImageDestroy($gfx);

?>