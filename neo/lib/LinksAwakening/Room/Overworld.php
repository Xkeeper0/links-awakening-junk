<?php

	namespace LinksAwakening\Room;

	class Overworld extends \LinksAwakening\Room {
		protected	$_indoors		= false;
		// Different object macros.

		protected	$_macros		= [
			0xf5	=> [
				'macro'		=> [
									[ 0x25, 0x26 ],
									[ 0x27, 0x28 ]
								],
				'replace'	=> [
								0x25 => 0x29,
								0x26 => 0x2A,
								0x27 => 0x2A,
								0x28 => 0x29,
								],
							],

			0xf7	=> [
				'macro'		=> [
									[ 0x55, 0x5a, 0x56 ],
									[ 0x57, 0x59, 0x58 ],
									[ 0x5b, 0xe2, 0x5b ],
								],
							],

			0xfd	=> [
				'macro'		=> [
									[ 0x52, 0x52, 0x52 ],
									[ 0x5b, 0xe2, 0x5b ],
								],
							],
		];

		protected function _handleMacro($x, $y, $tile) {
			// If we don't handle this macro, just bail now
			if (!isset($this->_macros[$tile])) {
				return false;
			}

			$tiles			= $this->_macros[$tile]['macro'];
			$replacements	= (isset($this->_macros[$tile]['replace']) ? $this->_macros[$tile]['replace'] : null);

			foreach ($tiles as $my => $mxTiles) {
				foreach ($mxTiles as $mx => $mtile) {
					// Get the tile we are replacing...
					$temp	= $this->getTile($x + $mx, $y + $my);
					if ($temp === null) continue;

					// Check if we should replace something first
					if ($replacements && isset($replacements[$temp])) {
						$this->_place($x + $mx, $y + $my, $replacements[$temp]);
					} else {
						$this->_place($x + $mx, $y + $my, $mtile);
					}
				}
			}

			return $this->_getMacroSize($tiles);

		}

	}
