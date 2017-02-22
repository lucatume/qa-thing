<?php

class qa_Ajax_Response extends WP_Ajax_Response {
	const ERROR = 0;
	const SUCCESS = 1;

	/**
	 * @var int
	 */
	protected $status = 200;

	/**
	 * @var
	 */
	protected $id = self::SUCCESS;

	/**
	 * @var mixed|string
	 */
	protected $action;

	/**
	 * @var mixed|string
	 */
	protected $data;

	/**
	 * qa_Ajax_Response constructor.
	 *
	 * @param array|string $args
	 */
	public function __construct($args) {
		$this->action = isset($args['action']) ? $args['action'] : 'action';
		$this->data = isset($args['data']) ? $args['data'] : '';

		$args = array(
			'what' => $this->action,
			'action' => 'qa_' . $this->action,
			'id' => $this->id,
			'data' => $this->data
		);

		$this->add($args);
	}

	/**
	 * Display XML formatted responses and sends the response header status.
	 *
	 * Differently from the base WP_Ajax_Response object it will return a different HTTP status.
	 *
	 * Sets the content type header to text/xml.
	 */
	public function send($die = true) {
		header('Content-Type: text/xml; charset=' . get_option('blog_charset'));
		echo "<?xml version='1.0' encoding='" . get_option('blog_charset') . "' standalone='yes'?><wp_ajax>";
		foreach ((array)$this->responses as $response) {
			echo $response;
		}
		echo '</wp_ajax>';

		if(!$die){
			return;
		}

		if (wp_doing_ajax()) {
			wp_die(null, null, $this->status);
		} else {
			die();
		}
	}

	/**
	 * @return int
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param int $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return mixed|string
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * @param mixed|string $action
	 */
	public function setAction($action) {
		$this->action = $action;
	}

	/**
	 * @return mixed|string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param mixed|string $data
	 */
	public function setData($data) {
		$this->data = $data;
	}
}