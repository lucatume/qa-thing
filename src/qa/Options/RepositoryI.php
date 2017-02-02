<?php

interface qa_Options_RepositoryI {
	/**
	 * Whether the plugin-provided examples are enabled or not.
	 *
	 * @return bool
	 */
	public function disableExamples();

	/**
	 * Updates the option in the database.
	 */
	public function update();

	/**
	 * Reads the option from the database.
	 */
	public function read();
}