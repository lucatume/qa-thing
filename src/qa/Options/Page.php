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
		?>
		<select name="qa-configuration" id="qa-configuration">
			<option value="foo" class="qa-configuration-option">Foo</option>
			<option value="baz" class="qa-configuration-option">Baz</option>
			<option value="bar" class="qa-configuration-option">Bar</option>
		</select>
		<?php
	}
}