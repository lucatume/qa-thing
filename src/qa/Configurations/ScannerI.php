<?php

interface qa_Configurations_ScannerI {

	/**
	 * Returns an array of the available configurations.
	 *
	 * @return qa_Configurations_ConfigurationI[]
	 */
	public function configurations();

	/**
	 * Gets a configuration by its id.
	 *
	 * @param string $id
	 * @return qa_Configurations_ConfigurationI|false Either the configuration object or `false` on failure.
	 */
	public function getConfigurationById($id);
}