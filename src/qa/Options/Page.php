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
	 * qa_Options_Page constructor.
	 * @param $slug
	 * @param qa_Configurations_ScannerI $scanner
	 * @param qa_RenderEngines_HandlebarsI $renderEngine
	 */
	public function __construct(
		$slug,
		qa_Configurations_ScannerI $scanner,
		qa_RenderEngines_HandlebarsI $renderEngine
	) {
		$this->slug = $slug;
		$this->scanner = $scanner;
		$this->renderEngine = $renderEngine;
	}

	public function render() {
		$data = array(
			'nothing-found' => __('Nothing found', 'qa'),
			'configurations' => $this->scanner->configurations()
		);
		echo $this->renderEngine->render('options-page', $data);
	}
}