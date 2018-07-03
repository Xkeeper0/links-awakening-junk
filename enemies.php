<?php

	ini_set("memory_limit", "256M");

	$known	= array(
		0x00	=> "*Arrow?",
		0x01	=> "*Boomerang (flies to you)",
		0x02	=> "*Explosion fizzlies?",
		0x03	=> "*Hookshot chain (retracts)",
		0x04	=> "*Hookshot hook",
		0x05	=> "*Pot (shatters instantly)",
		0x06	=> "*Pushed block (moves up)",
		0x07	=> "*Opening chest (w/ item)",
		0x08	=> "*???? (invisible)",
		0x09	=> "Octorok",
		0x0A	=> "*Rock (enemy projectile)",
		0x0B	=> "Moblin",
		0x0C	=> "*Arrow (enemy projectile)",
		0x0D	=> "Tektite",
		0x0E	=> "Leever",
		0x0F	=> "Armos statue",
		0x10	=> "Hiding Ghini",
		0x11	=> "Giant Ghini",
		0x12	=> "Ghini",
		0x13	=> "*Heart Container",			// you can kill it, it crashes the game if you run into it, and it works if you use the Magic Powder on it. Uh.
		0x14	=> "Sword Moblin",
		0x15	=> "Anti-Fairy",
		0x16	=> "Spark (counter-clockwise)",
		0x17	=> "Spark (clockwise)",
		0x18	=> "Pols Voice",
		0x19	=> "Keese",
		0x1A	=> "Stalfos (jumps to attack)",
		0x1B	=> "Gel",
		0x1C	=> "Mini-gel",
		0x1D	=> "*???? (invisible)",
		0x1E	=> "Stalfos (jumps away)",
		0x1F	=> "Gibdo",
		0x20	=> "Hardhat Beetle",
		0x21	=> "Wizrobe",
		0x22	=> "*Wizrobe (projectile)",
		0x23	=> "Like-like",
		0x24	=> "Iron Mask",
		0x25	=> "*Small explosion (enemy)",
		0x26	=> "*Small explosion (enemy)",
		0x27	=> "Spike trap",
		0x28	=> "Mimic",
		0x29	=> "Mini-Moldorm",
		0x2A	=> "Laser",
		0x2B	=> "*Laser beam segment",
		0x2C	=> "Spiked Beetle",
		0x2D	=> "Hiding heart",
		0x2E	=> "Hiding rupee",
		0x2F	=> "Hiding Fairy",
		0x30	=> "?Key/Drop point?",
		0x31	=> "Sword",
		0x32	=> "*???? (does nothing?)",
		0x33	=> "*Piece of Power",
		0x34	=> "*Guardian Acorn",
		0x35	=> "Heart Piece",
		0x36	=> "*Heart Container (works)",		// this one doesn't crash! how weird
		0x37	=> "Hiding arrow",
		0x38	=> "Hiding bomb",
		0x39	=> "?Instrument of the Sirens",
		0x3A	=> "Sleepy Toadstool",
		0x3B	=> "Hiding Magic Powder",
		0x3C	=> "?Hiding Slime Key?",
		0x3D	=> "Hiding Secret Seashell",
		0x3E	=> "Marin",
		0x3F	=> "Tarin (Raccoon)",
		0x40	=> "Witch",
		0x41	=> "?Owl event?",
		0x42	=> "Owl statue",
		0x43	=> "Seashell Mansion trees",
		0x44	=> "?Talking bones?",
		0x45	=> "Boulders",
		0x46	=> "Moving Block (left-top)",
		0x47	=> "Moving Block (left-bottom)",
		0x48	=> "Moving Block (bottom-left)",
		0x49	=> "Moving Block (bottom-rght)",
		0x4A	=> "Book (Color Dungeon)",
		0x4B	=> "*Pot (shatters)",
		0x4C	=> "*???? (invisible)",
		0x4D	=> "Shop Owner",
		0x4E	=> "*???? (invisible)",
		0x4F	=> "Trendy Game",
		0x50	=> "Boo Buddy",
		0x51	=> "Knight",
		0x52	=> "Vaccum Mouth",
		0x53	=> "Vaccum Mouth (reverse)",
		0x54	=> "Fisherman / Fishing game",
		0x55	=> "Bouncing Bombite",
		0x56	=> "Timer Bombite",
		0x57	=> "Pairodd",
		0x58	=> "*???? (disappears)",
		0x59	=> "!Giant Moldorm",
		0x5A	=> "!Faade",
		0x5B	=> "!Slime Eye",
		0x5C	=> "!Genie",
		0x5D	=> "!Slime Eel",
		0x5E	=> "!Ghoma",
		0x5F	=> "!Master Stalfos",
		0x60	=> "!Dodongo Snake",
		0x61	=> "Warp",
		0x62	=> "!Hot Head",
		0x63	=> "!Evil Eagle",
		0x64	=> "*Weird split-screen effect!",
		0x65	=> "!Angler Fish",
		0x66	=> "Crystal Switch",
		0x67	=> "*???? (invisible)",
		0x68	=> "*Weird tile-overwriting",
		0x69	=> "Moving Block mover",
		0x6A	=> "Raft / Raft Owner",
		0x6B	=> "*Text debugger!!",
		0x6C	=> "Cucco",
		0x6D	=> "Bow-wow",
		0x6E	=> "Butterfly",
		0x6F	=> "Dog",
		0x70	=> "Kid 70",
		0x71	=> "Kid 71",
		0x72	=> "Kid 72",
		0x73	=> "Kid 73",
		0x74	=> "Papahl's wife",
		0x75	=> "Grandma Ulrira",
		0x76	=> "Mr. Write",
		0x77	=> "Grandpa Ulrira",
		0x78	=> "Mini Bow-wow",
		0x79	=> "Madam Meowmeow",
		0x7A	=> "Crow",
		0x7B	=> "Crazy Tracy",
		0x7C	=> "Giant Goponga Flower",
		0x7D	=> "*Goponga Flower projectile",
		0x7E	=> "Goponga Flower",
		0x7F	=> "Turtle Rock head",
		0x80	=> "Telephone",
		0x81	=> "!Rolilng Bones",
		0x82	=> "!Rolling Bones' bar",
		0x83	=> "Dream Shrine bed",
		0x84	=> "Big Fairy",
		0x85	=> "Mr. Write's bird",
		0x86	=> "?Floating Item",
		0x87	=> "!Desert Lanmola",
		0x88	=> "!Armos Knight",
		0x89	=> "!Hinox",
		0x8A	=> "Tile glint (shown)",
		0x8B	=> "Tile glint (hidden)",
		0x8C	=> "*Weird (lands slowly)",
		0x8D	=> "*Weird (lands slowly)",
		0x8E	=> "!Cue Ball",
		0x8F	=> "Masked Mimic/Goriya",
		0x90	=> "Three-of-a-kind",
		0x91	=> "Anti-Kirby",
		0x92	=> "!Smasher",
		0x93	=> "Mad Bomber",
		0x94	=> "Kanlet's bombable walls",
		0x95	=> "Richard",
		0x96	=> "Richard's frogs",
		0x97	=> "?Diving warp event?",
		0x98	=> "Horse piece",
		0x99	=> "Water Tektite",
		0x9A	=> "Flying Tiles",
		0x9B	=> "Hiding Gel",
		0x9C	=> "Star",
		0x9D	=> "Liftable statue",
		0x9E	=> "Fireball shooter",
		0x9F	=> "Goomba",
		0xA0	=> "Peahat",
		0xA1	=> "Snake",
		0xA2	=> "Piranha Plant",
		0xA3	=> "Side-view platform (l/r)",
		0xA4	=> "Side-view platform (u/d)",
		0xA5	=> "Side-view platform",
		0xA6	=> "Side-view 'weights'",
		0xA7	=> "Pillar (for smashing)",
		0xA8	=> "*???? (does nothing?)",
		0xA9	=> "Blooper",
		0xAA	=> "Cheep-Cheep (horizontal)",
		0xAB	=> "Cheep-Cheep (vertical)",
		0xAC	=> "Cheep-Cheep (jumping)",
		0xAD	=> "Kiki the monkey",
		0xAE	=> "Winged Octorok",
		0xAF	=> "Trading Item",
		0xB0	=> "Pincer",
		0xB1	=> "Hole-filler",
		0xB2	=> "Beetle spawner",
		0xB3	=> "Honeycomb",
		0xB4	=> "Tarin",
		0xB5	=> "Bear",
		0xB6	=> "Papahl",
		0xB7	=> "Mermaid",
		0xB8	=> "Fisherman (under bridge)",
		0xB9	=> "Buzz Blob",
		0xBA	=> "Bomber",
		0xBB	=> "Bush crawler",
		0xBC	=> "!Grim Creeper",
		0xBD	=> "Vire",
		0xBE	=> "!Blaino",
		0xBF	=> "Zombies",
		0xC0	=> "?Signpost Maze?",
		0xC1	=> "Marin at the shore",
		0xC2	=> "Marin at Tal-Tal Heights",
		0xC3	=> "Mamu / Frogs",
		0xC4	=> "Walrus",
		0xC5	=> "Urchin",
		0xC6	=> "Sand crab",
		0xC7	=> "Manbo / Fish",
		0xC8	=> "*Bunny (calls Marin)",
		0xC9	=> "*Musical Note (?)",
		0xCA	=> "Mad Batter",
		0xCB	=> "Zora",
		0xCC	=> "Fish",
		0xCD	=> "Bananas / Schule / Sale",
		0xCE	=> "Mermaid statue",
		0xCF	=> "Seashell Mansion",
		0xD0	=> "?Animal D0",
		0xD1	=> "?Animal D1",
		0xD2	=> "?Animal D2",
		0xD3	=> "Bunny D3",
		0xD4	=> "*???? (invisible)",
		0xD5	=> "*???? (invisible)",
		0xD6	=> "Side-view pot",
		0xD7	=> "Mini-Thwomp",
		0xD8	=> "Thwomp",
		0xD9	=> "Thwomp (rammable)",
		0xDA	=> "Podoboo",
		0xDB	=> "Giant Bubble",
		0xDC	=> "Flying Rooster events",
		0xDD	=> "Book",
		0xDE	=> "?Egg song event?",
		0xDF	=> "*L2 Sword beam",
		0xE0	=> "Monkey",
		0xE1	=> "Witch's Rat",
		0xE2	=> "Flame Shooter",
		0xE3	=> "Pokey",
		0xE4	=> "Moblin King",
		0xE5	=> "?Floating Item",
		0xE6	=> "!Final Nightmare",
		0xE7	=> "Kanlet Castle gate switch",
		0xE8	=> "*Ending Owl/Stair-climbing",
		0xE9	=> "@Color Shell (red)",
		0xEA	=> "@Color Shell (green)",
		0xEB	=> "@Color Shell (blue)",
		0xEC	=> "@Color Ghoul (red)",
		0xED	=> "@Color Ghoul (green)",
		0xEE	=> "@Color Ghoul (blue)",
		0xEF	=> "@Rotoswitch (red)",
		0xF0	=> "@Rotoswitch (yellow)",
		0xF1	=> "@Rotoswitch (blue)",
		0xF2	=> "@Flying Hopper (bombs)",
		0xF3	=> "@Hopper",
		0xF4	=> "!Golem Boss?",
		0xF5	=> "*Bouncing boulder",
		0xF6	=> "@Color guardian (blue)",
		0xF7	=> "@Color guardian (red)",
		0xF8	=> "!Giant Buzz-Blob",
		0xF9	=> "!Color Dungeon boss?",
		0xFA	=> "?Photographer-related",
		0xFB	=> "*Crash",
		0xFC	=> "*Crash",
		0xFD	=> "*Weird (reset on Select)",	// you can kill it by hitting it with a pot, but it's invisible
		0xFE	=> "*Weird (solid to others)",	// it's also invisible
		0xFF	=> "*AWESOME crash!",			// restarts in half-GB mode! trippy!
		);

	#$count	= count($known);

	$fname	= "la12.gbc";
	if ($_GET['t']) {
		$fname	= "test.gbc";
	}
	$data	= file_get_contents($fname);

	$size	= 32;
	$scale	= 1;
	$xsize	= 160 / $scale;
	$ysize	= 128 / $scale;

	$m		= min(max(intval($_GET['m']), 0), 3);

	$start	= $_GET['offset'] += 0;
	$room	= $_GET['room'];
	$room	= hexdec($room);
	$rx		= ($room % 16) * $xsize;
	$ry		= floor($room / 16) * $ysize;

//	$image	= imagecreatetruecolor($xsize, $ysize);
	$image	= imagecreatetruecolor(448, $ysize);
	if ($_GET['t']) {
		$image2	= imagecreatefrompng("roomff.png");
		$rx	= 0;
		$ry	= 0;
	} else {
		$image2	= imagecreatefrompng("bigmap$m.png");
	}
	imagecopy($image, $image2, 0, 0, $rx, $ry, $xsize, $ysize);
	imagedestroy($image2);

	/*
	imagerectangle($image, 446 - 258, 123, 446, 126, 0x3333ff);
	imagefilledrectangle($image, 445 - 256, 124, 445, 125, 0x000060);
	imagefilledrectangle($image, 445 - $count, 124, 445, 125, 0x9999ff);
	imageoutlinetext($image, 1, 445 - $count, 116, floor($count/256*100) ."%", 0xccccff, 0x000060);
	imageoutlinetext($image, 3, 424, 113, $count, 0xffffff, 0x000050);
	*/

	$col[1]	= imagecolorallocatealpha($image, 255, 0, 0, 80);
	$o		= $start;
	while ($end == false && $i <= 16) {
		
		$val	= ord($data{$o});
		$val2	= ord($data{$o+1});

		if ($val == 0xFF) {
//			imageoutlinetext($image, 3, 167, $i * 12, hexout($o) ."  ". hexout($val) ." ". hexout($val2) ."  ". "End of data", 0x903030, 0x300000);
			$end = true;
			break;

		} elseif (substr($known[$val2], 0, 1) == "?") {	// unknowns
			$tx	= substr($known[$val2], 1);
			imageoutlinetext($image, 3, 167, $i * 12, hexout($o) ."  ". hexout($val) ." ". hexout($val2) ."  ". $tx, 0xb0ffb0, 0x005000);

		} elseif (substr($known[$val2], 0, 1) == "!") {	// bosses and such
			$tx	= substr($known[$val2], 1);
			imageoutlinetext($image, 3, 167, $i * 12, hexout($o) ."  ". hexout($val) ." ". hexout($val2) ."  ". $tx, 0xffb0b0, 0x500000);

		} elseif (substr($known[$val2], 0, 1) == "*") {	// bosses and such
			$tx	= substr($known[$val2], 1);
			imageoutlinetext($image, 3, 167, $i * 12, hexout($o) ."  ". hexout($val) ." ". hexout($val2) ."  ". $tx, 0xffff40, 0x505000);

		} elseif (substr($known[$val2], 0, 1) == "@") {	// bosses and such
			$tx	= substr($known[$val2], 1);
			imageoutlinetext($image, 3, 167, $i * 12, hexout($o) ."  ". hexout($val) ." ". hexout($val2) ."  ". $tx, 0xb0b0ff, 0x202060);

		} elseif ($known[$val2]) {
			imageoutlinetext($image, 3, 167, $i * 12, hexout($o) ."  ". hexout($val) ." ". hexout($val2) ."  ". $known[$val2], 0xffffff, 0x00007f);
		} else {
			imageoutlinetext($image, 3, 167, $i * 12, hexout($o) ."  ". hexout($val) ." ". hexout($val2) ."  ". "?", 0x8080ff, 0x000040);
		}

		$x		= ($val % 16);
		$y		= floor($val / 16);

		$t		= hexout($val2);

		imagefilledrectangle($image, $x * 16, $y * 16, $x * 16 + 15, $y * 16 + 15, $col[1]);
		imageoutlinetext($image, 3, $x * 16 + 1, $y * 16 + 2, $t, 0xffffff, 0x000000);


		$o		+= 2;
		$i		+= 1;
	}

	header("Content-type: image/png");
	imagepng($image);
	imagedestroy($image);


	function imageoutlinetext($i, $s, $x, $y, $text, $c1, $c2) {
		imagestring			($i, $s, $x + 1, $y    , $text, $c2);
		imagestring			($i, $s, $x    , $y + 1, $text, $c2);
		imagestring			($i, $s, $x - 1, $y    , $text, $c2);
		imagestring			($i, $s, $x    , $y - 1, $text, $c2);
		imagestring			($i, $s, $x + 1, $y + 1, $text, $c2);
		imagestring			($i, $s, $x - 1, $y + 1, $text, $c2);
		imagestring			($i, $s, $x - 1, $y - 1, $text, $c2);
		imagestring			($i, $s, $x + 1, $y - 1, $text, $c2);
		imagestring			($i, $s, $x, $y, $text, $c1);
	}

	function hexout($v, $l = 2) {
		return str_pad(strtoupper(dechex($v)), $l, "0", STR_PAD_LEFT);
	}

?>
