<?php
/** @var qa_Utils_Messages $messages */
$messages->information( 'This is an information: welcome to an example configuration script.' );

$var = 0;

$messages->information( 'The script will now add 1 to a variable each second...' );
$messages->notice( 'This is a notice: variable starts at 0' );

for ( $i = 0; $i < 5; $i ++ ) {
	sleep( 1 );
	$var ++;
	$messages->information( 'Variable value is now ' . $var );
}

if ( $var < 6 ) {
	$messages->error( 'This is an error: the variable value is less then 6.' );
}

sleep( 2 );

$messages->success( 'And we are done!' );



