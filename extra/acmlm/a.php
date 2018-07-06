<?php
/*
 $f=fopen('tiles.dat','r');
 $data=fread($f,1024);
 fclose($f);

 $f=fopen('tiles2.dat','wb');
 for($x=0;$x<1024;$x++){
   $n=ord($data[$x]);
   if($n<32)
     $n+=64;
   elseif($n>=108 && $n<112)
     $n-=108;
   elseif($n<128)
     $n+=128;
   elseif($n>=240)
     $n=128+($n%1)*16+floor(($n-240)/2);
   fwrite($f,chr($n),1);
 }
 fclose($f);
*/

 $f=fopen('tiles2.dat','r');
 $data=fread($f,1024);
 fclose($f);

 for($k=0;$k<4;$k++){
   for($x=0;$x<256;$x++){
     if(!($x%16))
       print '<br>.byte ';
     printf('$%02X',ord($data[$x*4+$k]));
     if(($x%16)!=15)
       print ',';
   }
   print '<br>';
 }
?>