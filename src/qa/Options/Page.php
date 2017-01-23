<?php

class qa_Options_Page implements qa__Options_PageI {
	/**
	 * @var string
	 */
	protected $slug;

	public function __construct( $slug ) {
		$this->slug = $slug;
	}

	public function render() {
		echo "Hello world";
	}
}