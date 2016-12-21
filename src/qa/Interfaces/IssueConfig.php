<?php


interface qa_Interfaces_IssueConfig {

	/**
	 * @return string
	 */
	public function getId();

	/**
	 * @return string
	 */
	public function getTitle();

	/**
	 * @return string
	 */
	public function getDescription();

	/**
	 * @return array
	 */
	public function getPlugin();

	/**
	 * @return string
	 */
	public function getPluginName();

	/**
	 * @return string
	 */
	public function getTarget();
}