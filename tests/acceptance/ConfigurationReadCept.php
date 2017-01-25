<?php
$I = new AcceptanceTester( $scenario );

$I->am( 'QA person' );
$I->wantTo( 'see QA plugin provided configurations in the QA options page' );

$I->loginAsAdmin();
$I->amOnAdminPage( '/admin.php?page=qa-options' );

// The QA Thing plugin itself provides them
$I->canSeeNumberOfElements( '#qa-configuration option', 3 );
