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
								0x27 => 0x2A,
								0x28 => 0x29,
								// 90 -> 82/83, but uh... need to
								// figure out how to represent that here, huh
								// (buried trees in mysterious woods)
								],
							],

			0xf6	=> [
				'macro'		=> [
									[ 0x55, 0x5a, 0x5a, 0x5a, 0x56 ],
									[ 0x57, 0x59, 0x59, 0x59, 0x58 ],
									[ 0x5b, 0xe2, 0x5b, 0xe2, 0x5b ],
								],
							],

			0xf7	=> [
				'macro'		=> [
									[ 0x55, 0x5a, 0x56 ],
									[ 0x57, 0x59, 0x58 ],
									[ 0x5b, 0xe2, 0x5b ],
								],
							],

			0xf8	=> [
				'macro'		=> [
									[ 0xb6, 0xb7, 0x66 ],
									[ 0x67, 0xe3, 0x68 ],
								],
							],

			0xf9	=> [
				'macro'		=> [
									[ 0xa4, 0xa5, 0xa6 ],
									[ 0xa7, 0xe3, 0xa8 ],
								],
							],

			0xfa	=> [
				'macro'		=> [
									[ 0xbb, 0xbc ],
									[ 0xbd, 0xbe ],
								],
							],

			0xfb	=> [
				'macro'		=> [
									[ 0xb6, 0xb7 ],
									[ 0xcd, 0xce ],
								],
							],

			0xfc	=> [
				'macro'		=> [
									[ 0x2b, 0x2c, 0x2d ],
									[ 0x37, 0xe8, 0x38 ],
									[ 0x33, 0x2f, 0x34 ],
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
