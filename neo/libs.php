<?php

	try {
		$file	= file_get_contents("../la12.gbc");
		$rom	= new DataSeeker($file);
		$rom->seek(0x69e2a);

		$roomdata	= new OverworldRoomData($rom);
		$c		= 0;
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
		
	} catch (Exception $e) {
		print "nice job idiot. ". $e->getMessage() ."\n";
	} finally {
		die("\nEnd\n");
	}




	// Generic library stuff for parsing room data.
	// This is not fully refactored. For example, some stuff should probably
	// be broken out into namespaces or other things,
	// but for now it's good enough.


	class RoomData {

		// Most of this is just reverse engineered from the format of the data,
		// not any sort of disassembly work

		// Could probably be put somewhere else, but for now I'll use this as a container

		// Special bytes for object data
		const	SPECIAL_WARPDATA	= 0xE0;
		const	LENGTH_VERTICAL		= 0xC0;
		const	LENGTH_HORIZONTAL	= 0x80;

		// These may be unused or invalid
		const	UNKNOWN_D0			= 0xD0;
		const	UNKNOWN_B0			= 0xB0;
		const	UNKNOWN_A0			= 0xA0;
		const	UNKNOWN_90			= 0x90;

		protected	$_rom			= null;		// DataSeeker with the ROM
		protected	$_initialOffset	= 0;		// Initial offset into DataSeeker

		protected	$_isIndoors		= null;		// Overworld/indoors
		protected	$_room			= null;		// Room object

		protected	$_animation		= null;
		protected	$_floorTile		= null;


		protected function __construct(DataSeeker $rom) {
			$this->_setROM($rom);
			$this->_parseHeader();
		}


		public function getRoom() {
			return $this->_room;
		}

		public function step() {
			$byte1	= $this->_rom->getI();
			printf("%02x ", $byte1);

			if ($byte1 === 0xFE) {
				print "end of data\n";
				return false;
			}

			$temp		= $byte1 & 0xF0;
			$vertical	= false;
			switch ($temp) {
				case self::SPECIAL_WARPDATA:
					$byte2		= $this->_rom->getI();
					$byte3		= $this->_rom->getI();
					$byte4		= $this->_rom->getI();
					$byte5		= $this->_rom->getI();
					printf("5 byte warp data - %02x %02x %02x %02x %02x\n", $byte1, $byte2, $byte3, $byte4, $byte5);
					$this->_rom->getS(4);
					break;
			
				case self::LENGTH_VERTICAL:
					$vertical	= true;

				case self::LENGTH_HORIZONTAL:
					$byte2		= $this->_rom->getI();
					$byte3		= $this->_rom->getI();
					$len		= ($byte1 & 0x0F);
					$x			= ($byte2 & 0x0F);
					$y			= ($byte2 & 0xF0) >> 4;					
					printf("3 byte object, %02x %02x %02x (%d-long %s, %d, %d)\n", $byte1, $byte2, $byte3, $len, ($vertical ? "vertical" : "horizontal"), $y, $x);
					$this->_room->addObject3($x, $y, $byte3, $len, $vertical);
					break;

				case self::UNKNOWN_D0:
				case self::UNKNOWN_B0:
				case self::UNKNOWN_A0:
				case self::UNKNOWN_90:
					throw new \Exception(sprintf("encountered unknown/unused special %02X", $byte1));

					break;

				default:
					$byte2	= $this->_rom->getI();
					$x		= ($byte1 & 0x0F);
					$y		= ($byte1 & 0xF0) >> 4;
					printf("2 byte object, %02x %02x (%d, %d)\n", $byte1, $byte2, $y, $x);
					$this->_room->addObject2($x, $y, $byte2);
					break;

			}

			return true;
		}




		protected function _setROM(DataSeeker $rom) {
			// We will assume that the dataseeker is already pointing to the data.
			$this->_rom				= $rom;
			$this->_initialOffset	= $rom->position();
		}

	}


	class OverworldRoomData extends RoomData {
		protected	$_isIndoors		= false;
		protected	$_tileset		= null;
		public function __construct(DataSeeker $rom, $tileset = null) {
			parent::__construct($rom);
			$this->_tileset	= $tileset;
			$this->_room	= new OverworldRoom($this->_animation, $this->_floorTile, null, $tileset, null);
		}

		protected function _parseHeader() {
			$this->_animation	= $this->_rom->getI();
			$this->_floorTile	= $this->_rom->getI();
		}
	}


	class IndoorRoomData extends RoomData {
		protected	$_isIndoors		= true;
		protected	$_template		= null;
		protected	$_dungeon		= null;

		public function __construct(DataSeeker $rom, $dungeon = null) {
			// Dungeon should determine if dungeon, cave, house, etc somewhere
			parent::__construct($rom);
			$this->_dungeon	= $dungeon;
			$this->_room	= new IndoorRoom($this->_animation, $this->_floorTile, $this->_template, null, $dungeon);
		}

		protected function _parseHeader() {
			// Dungeons have a template option, and their floor tiles
			// can only be 00-0F as a result
			$this->_animation	= $this->_rom->getI();

			$temp				= $this->_rom->getI();
			$this->_floorTile	= $temp & 0x0F;
			$this->_template	= ($temp & 0xF0) >> 4;
		}

	}



	class Room {

		const	BASE_TILE			= 0x400;	// Used to color floor/template tiles
		const	NEW_TILE			= 0x200;	// Used to color tiles written over floor/template
		const	OVERWRITTEN_TILE	= 0x100;	// Used to color tiles written over other tiles
		const	TILE_MASK			= 0x0FF;	// Tiles can only use 00-FF, so this & val = actual tile

		const	SIZE_W				= 10;
		const	SIZE_H				= 8;

		/* It's weird refactoring 13 year old code but here we are */
		protected	$_tiles			= [];
		protected	$_animation		= null;
		protected	$_floorTile		= null;
		protected	$_template		= null;
		protected	$_indoors		= null;
		protected	$_dungeon		= null;

		public function __construct($animation, $floorTile, $template = null, $tileset = null, $dungeon = null) {
			$this->_animation	= $animation;
			$this->_floorTile	= $floorTile;
			$this->_template	= $template;
			$this->_tileset		= $tileset;
			$this->_dungeon		= $dungeon;

			$this->_init($floorTile, $template);
		}

		/**
		 * Initialize empty room
		 */
		protected function _init($floor, $template) {
			for ($y = 0; $y < self::SIZE_H; $y++) {
				// Unlike the original code, this one keeps the "under layer"
				// as null instead of creating it with the template / floor.
				// This is to allow us to accurately show what gets written.
				$this->_tiles[$y]	= array_fill(0, self::SIZE_W, $floor + self::BASE_TILE);
			}

			if ($template !== null) {
				// do template here too.
			}

		}


		/**
		 * Reset the "drawn over" flags for the map
		 * 
		 * finalize will also remove the floor/template flags
		 */
		public function flush($finalize = false) {

			if ($finalize) {
				$mask		= self::TILE_MASK;
			} else {
				$mask		= self::BASE_TILE | self::TILE_MASK;
			}
			
			for ($y = 0; $y < self::SIZE_H; $y++) {
				for ($x = 0; $x < self::SIZE_W; $x++) {
					$this->_tiles[$y][$x]	= $this->_tiles[$y][$x] & $mask;
				}
			}
		}

		protected function _place($x, $y, $tile) {
			// X and Y can wrap around by drawing at the right edge (15).
			// Mostly used for trees and other large objects that need to
			// be off the left edge.
			$x	= $x & 0x0F;
			$y	= $y & 0x0F;
			if ($y > self::SIZE_H || $x > self::SIZE_W) {
				// don't draw off the room, that'd be silly.
				return;
			}

			if ($this->_tiles[$y][$x] & self::BASE_TILE) {
				// This tile is covering up the 'floor', so it's new.
				$mask	= self::NEW_TILE;
			} else {
				// This tile is covering up something already drawn.
				$mask	= self::OVERWRITTEN_TILE;
			}

			$this->_tiles[$y][$x]	= $mask | $tile;
		}

		public function addObject2($x, $y, $tile) {
			printf("  y=%2d  x=%2d  tile=%02x\n", $x, $y, $tile);
			$this->flush();
			$this->_place($x, $y, $tile);
		}

		public function addObject3($x, $y, $tile, $length, $vertical = false) {
			$this->flush();
			for ($i = 0; $i < $length; $i++) {
				printf("  x=%2d  y=%2d  tile=%02x\n", $x, $y, $tile);
				$this->_place($x, $y, $tile);
				if ($vertical) {
					$y++;
				} else {
					$x++;
				}
			}
		}


		public function dumpText($final = false) {
			if ($final) {
				$this->flush(true);
			}

			$out	= "";
			for ($y = 0; $y < self::SIZE_H; $y++) {
				for ($x = 0; $x < self::SIZE_W; $x++) {
					$out	.= sprintf("%3X ", $this->_tiles[$y][$x]);
				}
				$out	.= "\n";
			}

			return $out;

		}

		/**
		 * Flatten into a one-dimensional array
		 */
		public function dumpArray($final = false) {
			if ($final) {
				$this->flush(true);
			}

			$out	= [];
			for ($y = 0; $y < self::SIZE_H; $y++) {
				for ($x = 0; $x < self::SIZE_W; $x++) {
					$out[]	= $this->_tiles[$y][$x];
				}
			}

			return $out;

		}

	}


	class OverworldRoom extends Room {
		protected	$_indoors		= false;
		// Different object macros.

	}

	class IndoorRoom extends Room {
		protected	$_indoors		= true;
		// Different object macros.
	}



	class DataSeeker {
		protected	$_pointer	= 0;
		protected	$_length	= 0;
		protected	$_data		= null;

		/**
		 * Get a new data-seeker
		 * @param string $data Data to be used
		 */
		public function __construct(&$data) {
			$this->_data	= &$data;
			$this->_length	= strlen($data);
		}

		/**
		 * Get an integer from the binary data
		 * @param int $length Length of integer (bytes)
		 * @return int Integer
		 */
		public function getI($len = 1) {
			// not included here, so just inlined. shh
			//return Convert::toIntLE($this->_fetch($len));
			$temp	= $this->_fetch($len);
			$out	= 0;
			for ($i = 0; $i < $len; $i++) {
				$out	+= ord($temp{$i}) << (8 * $i);
			}
			return $out;
		}

		/**
		 * Get a raw string from the data
		 * @param int $length Length of string (bytes)
		 * @return string Raw byte data
		 */
		public function getS($len = 1) {
			return $this->_fetch($len);
		}

		/**
		 * Move the read pointer somewhere
		 * @param int Pointer's new byte position
		 */
		public function seek($ptr = 0) {
			if ($ptr >= $this->_length) {
				throw new Exception("Tried to put pointer past EOF");
			}
			$this->_pointer	= $ptr;
		}

		/**
		 * Get current read pointer position
		 * @return int Current read pointer position
		 */
		public function position() {
			return $this->_pointer;
		}

		/**
		 * Check if we are at the end of the file
		 * @return bool If readpointer is at EOF
		 */
		public function isEOF() {
			return $this->_pointer >= $this->_length;
		}

		/**
		 * Internal function to fetch data from the internal string
		 *
		 * Reads data from the internal string and returns it,
		 * like getS; handles advancing the read pointer
		 *
		 * @param int $len Length of data to read
		 * @return string Raw data
		 */
		protected function _fetch($len = 1) {
			if ($this->_pointer + $len > $this->_length) {
				throw new \Exception("Not enough data to fetch; wanted ". $len .", only have ". ($this->_length - $this->_pointer));
			}

			$ret			= substr($this->_data, $this->_pointer, $len);
			$this->_pointer	+= $len;
			return $ret;
		}

	}
