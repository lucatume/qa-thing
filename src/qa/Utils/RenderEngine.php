<?php


class qa_Utils_RenderEngine implements qa_Interfaces_RenderEngine {

	/**
	 * @var string The absolute path to the templates folder.
	 */
	protected $templates;

	public function __construct( $templates ) {
		if ( ! is_dir( $templates ) ) {
			throw new InvalidArgumentException( "Templates folder [{$templates}] does not exist" );
		}

		$this->templates = $templates;
	}

	/**
	 * Renders the specified template using the provided data.
	 *
	 * @param string $template
	 * @param array  $data An associative array of data.
	 *
	 * @return string
	 */
	public function render( $template, array $data = array() ) {
		ob_start();

		if ( ! empty( $data ) ) {
			extract( $data );
		}

		include $this->templates . DIRECTORY_SEPARATOR . ltrim( basename($template,'.php'), DIRECTORY_SEPARATOR ) . '.php';

		return ob_get_clean();
	}
}