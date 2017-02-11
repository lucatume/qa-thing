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

	/**
	 * Applies this configuration.
	 *
	 * @return int The configuration exit status; `0` for success and other values for errors or failures.
	 */
	public function apply();
}