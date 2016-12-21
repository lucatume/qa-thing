<?php


interface qa_Interfaces_IssueRepository {

	/**
	 * Returns all the issues.
	 *
	 * @return qa_Interfaces_IssueInterface[]
	 */
	public function getAll(  );

	/**
	 * @param $configSlug
	 *
	 * @return stdClass The plugin configuration object.
	 *
	 * @throws RuntimeException If the plugin was not found, the configuration file was
	 *                          not found, could not be read and decoded or the issue was
	 *                          not found in the configuration file.
	 */
	public function readConfigFor( $configSlug );
}