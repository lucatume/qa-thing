<?php


interface qa_Interfaces_RenderEngine {

	/**
	 * Renders the specified template using the provided data.
	 *
	 * @param  string $template
	 * @param array   $data An associative array of data.
	 *
	 * @return string
	 */
	public function render( $template, array $data = array() );
}