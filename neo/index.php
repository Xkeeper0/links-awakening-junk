

		<style type="text/css">
			body {
				font-family: Courier New, monospace;
				color: #99f;
				font-size:		1.0em;
				}
			table {
				font-size:	100%;
				}
			td	{
				background:		#113;
				border-right:	1px solid #336;
				border-bottom:	1px solid #559;
				padding:		.2em 1.5em .2em 1.5em;
				}
			.head	{
				background:		#202060;
				font-weight:	bold;
				border-right:	1px solid #336;
				border-bottom:	1px solid #559;
				}
			a	{
				color:			#9f9;
				}
		</style>

		<body bgcolor=050515><pre><font color=9999ff><b>Attempting to read level data from <font color=ffa0a0>0x68bc8</font> ...</b>
<?php

	require_once("includes.php");

	$animlookup	= array(
		0x00	=> 0,
		0x01	=> 0x0,
		0x02	=> 0x1,
		0x03	=> 0x2,  // 2?
		0x04	=> 0x3,
		0x05	=> 0x4,
		0x06	=> 0x5,
		0x07	=> 0x3,
		0x08	=> 0x6,
		0x09	=> 0x7,
		0x0a	=> 0x8,
		0x0b	=> 0x0,
		0x0c	=> 0x9,
		0x0d	=> 0xB,
		0x0e	=> 0xC,
		0x0f	=> 0xA,
		0x10	=> 0xD,
		);

	if (!isset($_GET['offset'])) {
		die("missing offset\n");
	}

	try {

		$file	= file_get_contents("../la12.gbc");
		$rom	= new Utils\DataSeeker($file);
		$rom->seek(hexdec($_GET['offset']));

		$roomdata	= new LinksAwakening\RoomData\Overworld($rom, isset($_GET['tset']) ? intval($_GET['tset']) : null);
		$c			= 0;

		$room	= $roomdata->getRoom();
		$suffix		= "&s1=". intval($_GET['tset']) ."&s2=". $animlookup[$room->getAnimation()];
		print "<table>";
		print "<tr><td>$c</td><td>";
		while ($roomdata->step()) {
			$c++;
			if ($c > 100) {
				break;
			}
			$room	= $roomdata->getRoom();
			$array	= $room->dumpArray();
			print "</td><td>";
			print "<img src='newdraw.php?n=". implode(",", $array) ."$suffix'>";
			print "</tr>";
			print "<tr><td>$c</td><td>";
		}

		$room	= $roomdata->getRoom();
		$room->flush();
		$array	= $room->dumpArray();
		$room->flush(true);
		$array2	= $room->dumpArray();

		print "</td><td>";
		print "<img src='newdraw.php?n=". implode(",", $array) ."$suffix'>";
		print "</td></tr>";
		print "<tr><td>&mdash;</td><td></td><td>";
		print "<img src='newdraw.php?n=". implode(",", $array2) ."$suffix'>";
		print "</td></tr></table>";

	} catch (\Exception $e) {
		print "Exception. ". $e->getMessage() ."\n";

	} catch (\Error $e) {
		print "Error. ". $e->getMessage() ."\n";

	} finally {
		die("\nEnd\n");

	}

		$anim	= $room->getAnimation();
