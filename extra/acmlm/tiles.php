<?php
 Header('Content-type:image/png');

 foreach($_GET as $k=>$v) {
	 $$k = $v;
 }

 $img=ImageCreate(273,273);
 ImageColorAllocate($img,50,50,220);
 if($b){
   $tiles=ImageCreate(128,128);
   ImageColorAllocate($tiles,90,82,255);
 }else
   $tiles=ImageCreateFromPNG('tiles.png');
 $sets1=ImageCreateFromPNG('sets1.png');
 $sets2=ImageCreateFromPNG('sets2.png');

 if($s1!='' && $s1>=0 && $s1<18)
   ImageCopy($tiles,$sets1,0,0,0,$s1*16,128,16);
 if($s2!='' && $s2>=0 && $s2<14)
   ImageCopy($tiles,$sets2,96,48,0,$s2*8,32,8);


 ImagePNG($tiles);
 ImageDestroy($tiles);
die();
 $f=fopen('tiles.dat','r');
 $data=fread($f,1024);
 fclose($f);

 for($x=0;$x<256;$x++){
   $px=($x%16)*17+1;
   $py=floor($x/16)*17+1;
   for($k=0;$k<4;$k++){
     $t=ord($data[$x*4+$k]);
     ImageCopy($img,$tiles,$px+($k%2)*8,$py+floor($k/2)*8,($t%16)*8,floor($t/16)*8,8,8);
   }
 }

 ImagePNG($img);
 ImageDestroy($img);

?>