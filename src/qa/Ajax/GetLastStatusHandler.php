<?php

class qa_Ajax_GetLastStatusHandler implements qa_Ajax_HandlerI {
	/**
	 * @var qa_Adapters_WordPressI|WP
	 */
	protected $wp;

	/**
	 * qa_Ajax_GetLastStatusHandler constructor.
	 * @param qa_Adapters_WordPressI $wp
	 */
	public function __construct(qa_Adapters_WordPressI $wp) {
		$this->wp = $wp;
	}

	/**
	 * Handles the request to get the last configuration application status.
	 *
	 * @param bool $send Whether the response object should be sent (`true`) or returned (`false`).
	 *
	 * @return qa_Ajax_Response An AJAX response object.
	 */
	public function handle($send = true) {
		$send = false === $send ? false : true;

		$data = $this->wp->get_option('qa-thing-last-run-status', '');
		$response = new qa_Ajax_Response(array('action' => 'get_last_status', 'data' => $data));

		if ($send) {
			$response->send();
		}
		return $response;
	}
}