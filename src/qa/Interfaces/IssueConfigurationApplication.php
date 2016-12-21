<?php


interface qa_Interfaces_IssueConfigurationApplication {

	/**
	 * Applies the requested configuration.
	 *
	 * @param qa_Interfaces_IssueConfig $config
	 *
	 * @return bool Whether the configuration was successfully applied or not.
	 */
	public function apply( qa_Interfaces_IssueConfig $config );
}