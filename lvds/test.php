<?php



for ($y = 0; $y <= 7; $y++) {
	for ($x = 0; $x <= 9; $x++) {
		$tile[$y][$x] = $_POST["tile". $y ."_". $x];
	}
}

print_r($tile);

for ($y = 0; $y <= 7; $y++) {
	for ($x = 0; $x <= 9; $x++) {
		print '$tile['. $y .']['. $x .'] = $tile'. $y .'_'. $x .';<br>';
	}
}


?>