<?php

class qa_Ajax_InternalErrorResponse extends qa_Ajax_Response {
	/**
	 * @var int
	 */
	protected $status = 500;

	/**
	 * @var int
	 */
	protected $id = self::ERROR;
}