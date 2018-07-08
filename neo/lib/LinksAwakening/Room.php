<?php

	namespace LinksAwakening;

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
