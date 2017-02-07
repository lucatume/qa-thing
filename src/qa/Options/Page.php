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
	 * @var qa_RenderEngines_HandlebarsI
	 */
	protected $renderEngine;
	/**
	 * @var qa_Adapters_WordPressI|WP
	 */
	private $wp;

	/**
	 * qa_Options_Page constructor.
	 * @param $slug
	 * @param qa_Configurations_ScannerI $scanner
	 * @param qa_RenderEngines_HandlebarsI $renderEngine
	 * @param qa_Adapters_WordPressI $wp
	 */
	public function __construct(
		$slug,
		qa_Configurations_ScannerI $scanner,
		qa_RenderEngines_HandlebarsI $renderEngine,
		qa_Adapters_WordPressI $wp
	) {
		$this->slug = $slug;
		$this->scanner = $scanner;
		$this->renderEngine = $renderEngine;
		$this->wp = $wp;
	}

	public function render() {
		$data = array(
			'nothing-found' => $this->wp->__('Nothing found', 'qa'),
			'configurations' => $this->scanner->configurations()
		);
		echo $this->renderEngine->render('options-page', $data);
	}
}