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
	 * @param array  $configuration
	 * @param array  $pluginData
	 */
	public function __construct( $id, array $configuration, array $pluginData ) {
		$this->id = sanitize_title( $pluginData['title'] ) . '::' . $id;
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