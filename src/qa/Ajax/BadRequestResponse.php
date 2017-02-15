<?php

class qa_Ajax_BadRequestResponse extends qa_Ajax_Response {

	/**
	 * @var int
	 */
	protected $status = 400;

	/**
	 * @var int
	 */
	protected $id = self::ERROR;
}