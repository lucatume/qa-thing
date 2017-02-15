<?php

interface qa_Ajax_HandlerI {

	/**
	 * Handles the request to handle a configuration.
	 *
	 * @param bool $send Whether the response object should be sent (`true`) or returned (`false`).
	 *
	 * @return qa_Ajax_Response An AJAX response object.
	 */
	public function handle($send = true);
}