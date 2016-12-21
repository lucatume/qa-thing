<?php


interface qa_Interfaces_Issue {

	/**
	 * Returns the issue unique identifier.
	 *
	 * @return string
	 */
	public function getId();

	/**
	 * Returns the issue title.
	 *
	 * @return string
	 */
	public function getTitle();

	/**
	 * @return string
	 */
	public function getTarget();
}