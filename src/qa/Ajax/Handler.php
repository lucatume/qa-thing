<?php

class qa_Ajax_Handler implements qa_Ajax_HandlerI {
	/**
	 * @var qa_Configurations_ScannerI
	 */
	protected $scanner;
	/**
	 * @var qa_Adapters_WordPressI|WP
	 */
	private $wp;

	/**
	 * qa_Ajax_AjaxHandler constructor.
	 * @param qa_Configurations_ScannerI $scanner
	 * @param qa_Adapters_WordPressI $wp
	 */
	public function __construct(qa_Configurations_ScannerI $scanner, qa_Adapters_WordPressI $wp) {
		$this->scanner = $scanner;
		$this->wp = $wp;
	}

	/**
	 * Handles the request to handle a configuration.
	 *
	 * @param bool $send Whether the response object should be sent (`true`) or returned (`false`).
	 *
	 * @return qa_Ajax_Response An AJAX response object.
	 */
	public function handle($send = true) {
		$send = false === $send ? false : true;

		if (!isset($_POST['id'])) {
			$data = $this->wp->__('The configuration id is missing', 'qa');
			$response = new qa_Ajax_BadRequestResponse(array('action' => 'apply_configuration', 'data' => $data));

			if ($send) {
				$response->send();
			}
			return $response;
		}

		$sanitized = is_string($_POST['id']) ? filter_var($_POST['id'], FILTER_SANITIZE_STRING) : false;
		if (!($sanitized && preg_match('/^.+?::+?/', $sanitized))) {
			$data = $this->wp->__('The configuration id is not a valid string', 'qa');
			$response = new qa_Ajax_BadRequestResponse(array('action' => 'apply_configuration', 'data' => $data));

			if ($send) {
				$response->send();
			}
			return $response;
		}

		if (!$this->wp->current_user_can('manage_options')) {
			$data = $this->wp->__('Current user cannot manage options', 'qa');
			$response = new qa_Ajax_InvalidAuthResponse(array('action' => 'apply_configuration', 'data' => $data));

			if ($send) {
				$response->send();
			}
			return $response;
		}

		$id = $_POST['id'];
		$configuration = $this->scanner->getConfigurationById($id);

		if (false === $configuration) {
			$data = $this->wp->__('The specified configuration was not found', 'qa');
			$response = new qa_Ajax_BadRequestResponse(array('action' => 'apply_configuration', 'data' => $data));

			if ($send) {
				$response->send();
			}
			return $response;
		}

		try {
			$status = $configuration->apply();
		} catch (Exception $e) {
			$data = $this->statusToMessage(-1);
			$response = new qa_Ajax_InternalErrorResponse(array(
				'action' => 'apply_configuration',
				'data' => end($data)
			));

			$this->wp->update_option('qa-thing-last-run-status', $this->statusToRunStatus(-1));

			if ($send) {
				$response->send();
			}
			return $response;
		}

		$this->wp->update_option('qa-thing-last-run-status', $this->statusToRunStatus($status));

		$data = $this->statusToMessage($status);
		$response = new qa_Ajax_Response(array('action' => 'apply_configuration', 'data' => end($data)));

		if ($send) {
			$response->send();
		}

		return $response;
	}

	/**
	 * @param int $status
	 *
	 * @return array
	 */
	protected function statusToMessage($status) {
		$map = array(
			0 => $this->wp->__('Success! The configuration was successfully applied.', 'qa'),
			1 => $this->wp->__('Failure... The configuration was applied correctly but something went wrong.', 'qa'),
			-1 => $this->wp->__('Error! The configuration generated one or more errors during its application.', 'qa'),
			-33 => $this->wp->__('Error! The configuration target script cannot be found.', 'qa'),
			-100 => $this->wp->__('Time out! The configuration target script timed out.', 'qa'),
		);

		$unknown = $this->wp->__('The exit status returned by the configuration is not a recognized one.', 'qa');

		return isset($map[$status]) ?
			array('status' => $status, 'message' => $map[$status])
			: array('status' => $status, 'message' => $unknown);
	}

	/**
	 * @param int $status
	 *
	 * @return string
	 */
	protected function statusToRunStatus($status) {
		$map = array(
			0 => 'success',
			1 => 'fail',
			-1 => 'error',
			-33 => 'not-found',
			-100 => 'time-out',
		);

		return isset($map[$status]) ? $map[$status] : 'unknown';
	}
}