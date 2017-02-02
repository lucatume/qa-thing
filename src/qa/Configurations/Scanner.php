<?php

class qa_Configurations_Scanner implements qa_Configurations_ScannerI {
	/**
	 * @var qa_Adapters_WordPressI
	 */
	protected $wp;

	/**
	 * @var qa_Options_RepositoryI
	 */
	protected $options;

	public function __construct(qa_Adapters_WordPressI $wordPress, qa_Options_RepositoryI $options) {
		$this->wp = $wordPress;
		$this->options = $options;
	}

	/**
	 * Returns an array of the available configurations.
	 *
	 * @return qa_Configurations_ConfigurationI[]
	 */
	public function configurations() {
		$configurationProviders = $this->scanPlugins();

		if (empty($configurationProviders)) {
			return array();
		}

		$configurations = array_filter(array_map(array($this, 'buildConfigurations'), $configurationProviders));

		return empty($configurations) ? array() : call_user_func_array('array_merge', $configurations);
	}

	protected function scanPlugins() {
		$plugins = $this->wp->get_plugins();

		if ($this->options->disableExamples()) {
			unset($plugins['qa-thing/qa-thing.php']);
		}

		if (empty($plugins)) {
			return array();
		}

		array_walk($plugins, array($this, 'addDetails'));

		$plugins = array_filter($plugins, array($this, 'hasConfig'));

		return $plugins;
	}

	protected function addDetails(array &$data, $path) {
		$data['path'] = $this->wp->plugin_dir($path);
		$data['root'] = dirname($this->wp->plugin_dir($path));
		$data['slug'] = isset($data['text-domain']) ? $data['text-domain'] : urlencode($data['Title']);
	}

	protected function hasConfig(array $data) {
		$config = $data['root'] . '/qa/qa-config.json';
		if (!is_readable($config)) {
			return false;
		}

		$decoded = json_decode(file_get_contents($config));

		return !empty($decoded->configurations);
	}

	protected function buildConfigurations(array $data) {
		$info = file_get_contents($data['root'] . '/qa/qa-config.json');
		$info = (array)json_decode($info);
		$configurations = array();
		foreach ($info['configurations'] as $id => $configuration) {
			try {
				$configurations[] = new qa_Configurations_Configuration($id, (array)$configuration, $data);
			} catch (InvalidArgumentException $e) {
				// skip this: it's invalid
			}
		}

		return $configurations;
	}
}