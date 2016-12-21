<?php
/** @var qa_Utils_Messages $messages */
$messages->information( 'This script is meant to fail throwing an exception. The plugin should capture it.' );

throw new RuntimeException( 'This runtime exception should have been logged' );



