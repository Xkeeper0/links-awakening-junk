<?php

$map = ImageCreate(16, 16);
$graphicset = ImageCreateFromPNG("level8_r.png");  

ImageCopy($map, $graphicset, 0, 0, 0, 0, 16, 16);

Header("Content-type:image/png");
ImagePNG($map);

imagedestroy($map);
imagedestroy($graphicset);
imagedestroy($img);
imagedestroy($gfx);

?>
