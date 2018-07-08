<?php

	require_once("includes.php");

	try {
		$file	= file_get_contents("../la12.gbc");
		$rom	= new Utils\DataSeeker($file);
		$rom->seek(0x68bc8);

		$roomdata	= new LinksAwakening\RoomData\Overworld($rom);
		$c			= 0;

		while ($roomdata->step()) {
			$c++;
			if ($c > 100) {
				break;
			}
		}

		$room	= $roomdata->getRoom();
		print $room->dumpText() ."\n";
		$array	= $room->dumpArray();
		//print $room->dumpText(true);
		$room->flush();
		$array2	= $room->dumpArray();
		//$array2	= $room->dumpArray();

		print "http://localhost/la/neo/newdraw.php?n=". implode(",", $array) ."&s1=6&s2=2\n";
		print "http://localhost/la/neo/newdraw.php?n=". implode(",", $array2) ."&s1=6&s2=2\n";

	} catch (\Exception $e) {
		print "Exception. ". $e->getMessage() ."\n";

	} catch (\Error $e) {
		print "Error. ". $e->getMessage() ."\n";

	} finally {
		die("\nEnd\n");

	}
