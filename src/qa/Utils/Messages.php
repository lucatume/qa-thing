<?php


class qa_Utils_Messages {

	/**
	 * @var stiring
	 */
	protected $option;

	/**
	 * @var int
	 */
	protected $transientExpiration = 600;

	/**
	 * @var qa_Interfaces_MessageFormatter
	 */
	private $formatter;

	public function __construct( $option, qa_Interfaces_MessageFormatter $formatter ) {
		$this->option    = $option;
		$this->formatter = $formatter;
	}

	public function information( $message ) {
		$content   = (array) get_transient( $this->option );
		$content[] = $this->formatter->formatInformation( $message );
		set_transient( $this->option, $content, $this->transientExpiration );
	}

	public function notice( $message ) {
		$content   = (array) get_transient( $this->option );
		$content[] = $this->formatter->formatNotice( $message );
		set_transient( $this->option, $content, $this->transientExpiration );
	}

	public function success( $message ) {
		$content   = (array) get_transient( $this->option );
		$content[] = $this->formatter->formatSuccess( $message );
		set_transient( $this->option, $content, $this->transientExpiration );
	}

	public function error( $message ) {
		$content   = (array) get_transient( $this->option );
		$content[] = $this->formatter->formatError( $message );
		set_transient( $this->option, $content, $this->transientExpiration );
	}
}