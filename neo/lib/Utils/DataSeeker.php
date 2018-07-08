<?php

	namespace Utils;

	/**
	 * Seekable data thing, useful for script proccessing stuff
	 */
	class DataSeeker {
		protected	$_pointer	= 0;
		protected	$_length	= 0;
		protected	$_data		= null;

		/**
		 * Get a new data-seeker
		 * @param string $data Data to be used
		 */
		public function __construct($data) {
			$this->_data	= $data;
			$this->_length	= strlen($data);
		}

		/**
		 * Get an integer from the binary data
		 * @param int $length Length of integer (bytes)
		 * @return int Integer
		 */
		public function getI($len = 1) {
			return Convert::toIntLE($this->_fetch($len));
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
