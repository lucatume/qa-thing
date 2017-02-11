<?php

interface qa_Ajax_AjaxHandlerI {

	/**
	 * Handles the request to handle a configuration.
	 *
	 * @return array An array of data representing the configuration application status.
	 */
	public function handle();
}