<?php

class qa_Ajax_InvalidAuthResponse extends qa_Ajax_Response {
	/**
	 * @var int
	 */
	protected $status = 403;

	/**
	 * @var int
	 */
	protected $id = self::ERROR;
}