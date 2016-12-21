<?php


class qa_Issues_Config implements qa_Interfaces_IssueConfig {

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var array
	 */
	protected $plugin;

	/**
	 * @var string
	 */
	protected $target;

	public function __construct( stdClass $issueConfig ) {
		$this->title = $issueConfig->title;
		$this->description = ! empty( $issueConfig->description ) ? $issueConfig->description : __( 'No description provided', 'app' );
		$this->plugin = $issueConfig->plugin;
		$this->target = $issueConfig->target;
		$this->id = sanitize_title( $issueConfig->plugin['Name'] ) . ':' . $issueConfig->id;
	}


	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return array
	 */
	public function getPlugin() {
		return $this->plugin;
	}

	/**
	 * @return string
	 */
	public function getPluginName() {
		return empty( $this->plugin['Name'] ) ? __( 'Unknown', 'app' ) : $this->plugin['Name'];
	}

	/**
	 * @return string
	 */
	public function getTarget() {
		return $this->target;
	}
}