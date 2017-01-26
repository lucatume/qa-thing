<?php

interface qa_Configurations_ConfigurationI {

	/**
	 * Returns the configuration id.
	 *
	 * @return string
	 */
	public function id();

	/**
	 * Returns the configuration name.
	 *
	 * @return string
	 */
	public function name();
}