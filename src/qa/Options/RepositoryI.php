<?php

interface qa_Options_RepositoryI {
	/**
	 * Whether the plugin-provided examples are enabled or not.
	 *
	 * @return bool
	 */
	public function disableExamples();
}