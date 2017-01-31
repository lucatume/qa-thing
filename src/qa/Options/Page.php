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
	/**
	 * @var qa_Options_RepositoryI
	 */
	protected $options;

	/**
	 * qa_Options_Page constructor.
	 * @param $slug
	 * @param qa_Configurations_ScannerI $scanner
	 * @param qa_Options_RepositoryI $options
	 */
	public function __construct($slug, qa_Configurations_ScannerI $scanner, qa_Options_RepositoryI $options) {
		$this->slug = $slug;
		$this->scanner = $scanner;
		$this->options = $options;
	}

	public function render() {
		?>
        <select name="qa-configuration" id="qa-configuration">
			<?php if (!$this->options->disableExamples()) : ?>
                <option value="foo" class="qa-configuration-option">Foo</option>
                <option value="baz" class="qa-configuration-option">Baz</option>
                <option value="bar" class="qa-configuration-option">Bar</option>
			<?php endif; ?>
			<?php /** @var qa_Configurations_ConfigurationI $configuration */
			foreach ($this->scanner->configurations() as $configuration) : ?>
                <option value="<?php echo $configuration->id() ?>"
                        class="qa-configuration-option"><?php echo $configuration->name() ?></option>
			<?php endforeach; ?>
        </select>
		<?php
	}
}