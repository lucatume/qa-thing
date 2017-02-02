<?php

interface qa_RenderEngines_HandlebarsI {
	/**
	 * Shortcut 'render' invocation.
	 *
	 * Equivalent to calling `$handlebars->loadTemplate($template)->render($data);`
	 *
	 * @param string $template template name
	 * @param mixed $data data to use as context
	 *
	 * @return string Rendered template
	 * @see Handlebars_Engine::loadTemplate
	 * @see Handlebars_Template::render
	 */
	public function render($template, $data);
}