<?php

	namespace Utils;

	class Convert {

		/**
		 * Convert a string of little-endian bytes into an integer
		 * @param string $s Byte data to Convert
		 * @return int Integer value of data
		 */
		public static function toIntLE($s) {
			$out	= 0;
			$sl		= strlen($s);
			for ($i = 0; $i < $sl; $i++) {
				$out	+= ord($s{$i}) << (8 * $i);
			}
			return $out;
		}

		/**
		 * Pretty-print out binary data in hexadecimal.
		 * Technically bin2hex() does this but without spaces
		 * @param string $s Raw byte data
		 * @return string $s Slightly better bin2hex() output
		 */
		public static function printableHex($s) {
			$len	= strlen($s);
			$out	= "";
			for ($i = 0; $i < $len; $i++) {
				$out .= ($i ? " " : "") . sprintf("%02x", ord($s{$i}));
			}
			return $out;
		}
	}
