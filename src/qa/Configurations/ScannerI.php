<?php

interface qa_Configurations_ScannerI {

	/**
	 * Returns an array of the available configurations.
	 *
	 * @return qa_Configurations_ConfigurationI[]
	 */
	public function configurations();
}