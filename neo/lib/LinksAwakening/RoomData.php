<?php

	namespace LinksAwakening;

	abstract class RoomData {

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


		protected function __construct(\Utils\DataSeeker $rom) {
			$this->_setROM($rom);
			$this->_parseHeader();
		}


		public function getRoom() {
			return $this->_room;
		}

		public function step() {
			$byte1	= $this->_rom->getI();

			if ($byte1 === 0xFE) {
				print "End of room data\n";
				return false;
			}

			$special		= $byte1 & 0xF0;
			$vertical	= false;
			switch ($special) {
				case self::SPECIAL_WARPDATA:
					$byte2		= $this->_rom->getI();
					$byte3		= $this->_rom->getI();
					$byte4		= $this->_rom->getI();
					$byte5		= $this->_rom->getI();
					printf("5 byte warp data - %02x %02x %02x %02x %02x\n", $byte1, $byte2, $byte3, $byte4, $byte5);
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




		protected function _setROM(\Utils\DataSeeker $rom) {
			// We will assume that the dataseeker is already pointing to the data.
			$this->_rom				= $rom;
			$this->_initialOffset	= $rom->position();
		}

	}
