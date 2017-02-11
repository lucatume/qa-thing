<?php

class qa_Ajax_AjaxHandler implements qa_Ajax_AjaxHandlerI {
	/**
	 * @var qa_Configurations_ScannerI
	 */
	protected $scanner;

	public function __construct(qa_Configurations_ScannerI $scanner) {

		$this->scanner = $scanner;
	}

	/**
	 * Handles the request to handle a configuration.
	 *
	 * @return array An array of data representing the configuration application status.
	 */
	public function handle() {
		$id = $_POST['id'];
		$configuration = $this->scanner->getConfigurationById($id);

		try {
			$status = $configuration->apply();
		} catch (Exception $e) {
			$status = -1;
		}

		update_option('qa-thing-last-run-status', $this->statusToRunStatus($status));

		$data = $this->statusToMessage($status);

		wp_die(json_encode($data));
	}

	/**
	 * @param int $status
	 *
	 * @return string
	 */
	protected function statusToMessage($status) {
		$map = array(
			0 => __('Success! The configuration was successfully applied.', 'qa'),
			1 => __('Failure... The configuration was applied correctly but something went wrong.', 'qa'),
			-1 => __('Error! The configuration generated one or more errors during its application.', 'qa'),
			-33 => __('Error! The configuration target script cannot be found.', 'qa'),
			-100 => __('Time out! The configuration target script timed out.', 'qa'),
		);

		$unknown = __('The exit status returned by the configuration is not a recognized one.', 'qa');

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