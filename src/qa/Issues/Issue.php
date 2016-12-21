<?php


class qa_Issues_Issue implements qa_Interfaces_IssueInterface, qa_Interfaces_Issue {

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
	protected $target;
	/**
	 * @var array
	 */
	protected $plugin;
	/**
	 * @var string
	 */
	protected $description;

	/**
	 * qa_Issues_Issue constructor.
	 *
	 * @param string  $id
	 * @param string  $title
	 * @param  string $target
	 * @param array   $plugin
	 * @param string  $description
	 */
	public function __construct( $id, $title, $target, array $plugin, $description = '' ) {

		$this->id = $id;
		$this->title = $title;
		$this->target = $target;
		$this->plugin = $plugin;
		$this->description = $description;
	}

	/**
	 * Returns the issue unique identifier.
	 *
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the issue title.
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getTarget() {
		return $this->target;
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
	public function getDescription() {
		return $this->description;
	}
}