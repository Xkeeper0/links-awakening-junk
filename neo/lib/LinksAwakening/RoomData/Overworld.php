<?php

	namespace LinksAwakening\RoomData;

	class Overworld extends \LinksAwakening\RoomData {
		protected	$_isIndoors		= false;
		protected	$_tileset		= null;
		public function __construct(\Utils\DataSeeker $rom, $tileset = null) {
			parent::__construct($rom);
			$this->_tileset	= $tileset;
			$this->_room	= new \LinksAwakening\Room\Overworld($this->_animation, $this->_floorTile, null, $tileset, null);
		}

		protected function _parseHeader() {
			$this->_animation	= $this->_rom->getI();
			$this->_floorTile	= $this->_rom->getI();
		}
	}
