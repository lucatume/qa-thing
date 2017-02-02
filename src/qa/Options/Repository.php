<?php

class qa_Options_Repository implements qa_Options_RepositoryI, ArrayAccess {
	/**
	 * @var array
	 */
	protected $option = array();

	/**
	 * @var string
	 */
	private $optionName;
	/**
	 * @var qa_Adapters_WordPressI
	 */
	protected $wp;

	/**
	 * qa_Options_Repository constructor.
	 *
	 * @param string $optionName
	 * @param qa_Adapters_WordPressI $wp
	 */
	function __construct($optionName = 'qa-thing', qa_Adapters_WordPressI $wp) {
		if (!is_string($optionName)) {
			throw new InvalidArgumentException('Option name must be a string');
		}
		$this->optionName = $optionName;
		$this->wp = $wp;
		$this->read();
	}

	/**
	 * Whether the plugin-provided examples are enabled or not.
	 *
	 * @return bool
	 */
	public function disableExamples() {
		return true == $this->offsetGet('disable-examples');
	}

	/**
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists($offset) {
		return isset($this->option[$offset]);
	}

	/**
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 * @since 5.0.0
	 */
	public function offsetGet($offset) {
		return isset($this->option[$offset]) ? $this->option[$offset] : null;
	}

	/**
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetSet($offset, $value) {
		$this->option[$offset] = $value;
	}

	/**
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset($offset) {
		unset($this->option[$offset]);
	}

	/**
	 * On destruct write the option to the database.
	 */
	public function __destruct() {
		$this->update();
	}

	/**
	 * Updates the option in the database.
	 */
	public function update() {
		$this->wp->update_option($this->optionName, $this->option);
	}

	/**
	 * Reads the option from the database.
	 */
	public function read() {
		$read = $this->wp->get_option($this->optionName);
		$this->option = empty($read) ? array() : $read;
	}
}