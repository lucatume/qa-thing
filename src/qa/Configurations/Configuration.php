<?php

class qa_Configurations_Configuration implements qa_Configurations_ConfigurationI {
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
}