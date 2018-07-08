<?php

	require_once("includes.php");

	try {
		$file	= file_get_contents("../la12.gbc");
		$rom	= new Utils\DataSeeker($file);
		$rom->seek(0x69e2a);

		$roomdata	= new LinksAwakening\RoomData\Overworld($rom);
		$c			= 0;

		while ($roomdata->step()) {
			$c++;
			if ($c > 100) {
				die("something probably went wrong with this so let's just stop now, thanks\n");
			}
		}

		$room	= $roomdata->getRoom();
		print $room->dumpText() ."\n";
		$array	= $room->dumpArray();
		//print $room->dumpText(true);
		$room->flush();
		$array2	= $room->dumpArray();
		//$array2	= $room->dumpArray();

		print "http://localhost/la/extra/newdraw.php?n=". implode(",", $array) ."&s1=9&s2=2\n";
		print "http://localhost/la/extra/newdraw.php?n=". implode(",", $array2) ."&s1=9&s2=2\n";

	} catch (\Exception $e) {
		print "Exception. ". $e->getMessage() ."\n";

	} catch (\Error $e) {
		print "Error. ". $e->getMessage() ."\n";

	} finally {
		die("\nEnd\n");

	}
