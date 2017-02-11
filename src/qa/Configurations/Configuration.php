<?php

class qa_Configurations_Configuration implements qa_Configurations_ConfigurationI, ArrayAccess {
	/**
	 * @var array
	 */
	protected $methodMap = array('name' => 'name', 'id' => 'id');

	/**
	 * @var array
	 */
	protected $configuration;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * qa_Configurations_Configuration constructor.
	 *
	 * @param string $id
	 * @param array $configuration
	 * @param array $pluginData
	 */
	public function __construct($id, array $configuration, array $pluginData) {
		if (empty($pluginData['slug']) || !is_string($pluginData['slug'])) {
			throw new InvalidArgumentException('Plugin slug is not set or not a string');
		}

		if (empty($configuration['title']) || !is_string($configuration['title'])) {
			throw new InvalidArgumentException('Configuration title is missing or not a string');
		}

		if (empty($configuration['target']) || (!is_string($configuration['target']) && !is_array($configuration['target']) && !is_object($configuration['target']))) {
			throw new InvalidArgumentException('Configuration target is missing or not a string or an array');
		}

		$this->id = $pluginData['slug'] . '::' . $id;
		$this->configuration = $configuration;
		$this->data = $pluginData;
	}

	/**
	 * Returns the configuration id.
	 *
	 * @return string
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * Returns the configuration name.
	 *
	 * @return string
	 */
	public function name() {
		return $this->configuration['title'];
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
		return isset($this->methodMap[$offset]);
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
		isset($this->methodMap[$offset]) ? call_user_func(array($this, $this->methodMap[$offset])) : null;
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
		// nope
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
		// nope
	}

	/**
	 * Applies this configuration.
	 *
	 * @return int The configuration exit status; `0` for success and other values for errors or failures.
	 */
	public function apply() {
		$target = $this->configuration['target'];
		$path = $target;

		if (!file_exists($path)) {
			// relative to plugin root folder
			$path = $this->data['root'] . DIRECTORY_SEPARATOR . trim($path, DIRECTORY_SEPARATOR);
		}

		if (!file_exists($path)) {
			return -33;
		}

		return include $path;
	}
}