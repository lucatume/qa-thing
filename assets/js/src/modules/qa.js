var QA = window.QA || {},
	Intercooler = require( "exports?Intercooler!./../../../../node_modules/intercooler/src/intercooler.js" );

QA.App = function () {
	var self = this;
	this.nonce = QA.nonce;
	this.form = $( 'form#qa' );
	this.applyButton = $( 'button#qa-apply' );
	this.workLog = $( '#qa-work-log' );
	this.configurations = $( '#qa-configuration' );
	this.workingTitle = $( '#qa-working-title' );
	this.workTitle = $( '#qa-work-title' );

	this.preventFormSubmission = function () {
		self.form.submit( function ( ev ) {
			ev.preventDefault();
		} );
	};

	this.handleButtonClick = function () {
		var selected = self.configurations.val();

		if ( !selected ) {
			return;
		}

		self.workLog.empty();
		self.workLog.attr( 'ic-pause-polling', 'false' );
		self.applyButton.addClass( 'disabled' ).removeClass( 'button-primary' );
		var configurationTitle = self.configurations.find( ':selected' ).text();
		self.workTitle.hide();
		self.workTitle.find( '.target' ).text( configurationTitle );
		self.workingTitle.find( '.target' ).text( configurationTitle );
		self.workingTitle.show();
		Intercooler.processNodes( self.workLog );
	};

	this.beforeSend = function ( evt, elt, data, settings, xhr ) {
		if ( !(self.nonce && xhr) ) {
			return;
		}

		xhr.setRequestHeader( 'X-WP-Nonce', self.nonce );
	};

	this.success = function ( evt, elt, data, textStatus, xhr, requestId ) {
		if ( xhr.getResponseHeader( 'X-IC-CancelPolling' ) ) {
			self.applyButton.removeClass( 'disabled' ).addClass( 'button-primary' );
			self.workingTitle.hide();
			self.workTitle.show();
		}
	};

	this.start = function () {
		self.preventFormSubmission();
		$( '.wp-rest' ).on( 'beforeSend.ic', self.beforeSend );
		$( '.wp-rest' ).on( 'success.ic', self.success );
		self.applyButton.click( self.handleButtonClick );
	};

};

module.exports = new QA.App();
