<?php

class qa_Options_Page implements qa_Options_PageI {
	/**
	 * @var string
	 */
	protected $slug;
	/**
	 * @var qa_Configurations_ScannerI
	 */
	protected $scanner;

	public function __construct( $slug, qa_Configurations_ScannerI $scanner ) {
		$this->slug = $slug;
		$this->scanner = $scanner;
	}

	public function render() {
		?>
        <select name="qa-configuration" id="qa-configuration">
			<?php /** @var qa_Configurations_ConfigurationI $configuration */
			foreach ( $this->scanner->configurations() as $configuration ) : ?>
                <option value="<?php echo $configuration->id() ?>"
                        class="qa-configuration-option"><?php echo $configuration->name() ?></option>
			<?php endforeach; ?>
            <option value="foo" class="qa-configuration-option">Foo</option>
            <option value="baz" class="qa-configuration-option">Baz</option>
            <option value="bar" class="qa-configuration-option">Bar</option>
        </select>
		<?php
	}
}