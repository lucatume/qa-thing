// expose the global jQuery object from WordPress
window.$ = window.jQuery = jQuery;

var app = require( './modules/qa.js' );

$( document ).ready( app.start );

window.QA.App = app;


