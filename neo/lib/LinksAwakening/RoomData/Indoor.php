<?php

	namespace LinksAwakening\RoomData;

	class Indoor extends \LinksAwakening\RoomData {
		protected	$_isIndoors		= true;
		protected	$_template		= null;
		protected	$_dungeon		= null;

		public function __construct(\Utils\DataSeeker $rom, $dungeon = null) {
			// Dungeon should determine if dungeon, cave, house, etc somewhere
			parent::__construct($rom);
			$this->_dungeon	= $dungeon;
			$this->_room	= new \LinksAwakening\Room\Indoor($this->_animation, $this->_floorTile, $this->_template, null, $dungeon);
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
