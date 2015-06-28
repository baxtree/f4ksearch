<?php
/*
 * This file is for removing a single item base on its id (the trailing number of the $testdepositurl value) from DataShare devel.
 */
	$item_id = $_GET["id"];

	$dsdevcollecionurl = "http://devel.edina.ac.uk:9228/handle/123456789/1";

	$testurl = "http://devel.edina.ac.uk:9228/swordv2/servicedocument";

	$testuser = "xi.bai@ed.ac.uk";

	$testpw = "*****************";

	$testdepositurl = "http://devel.edina.ac.uk:9228/swordv2/collection/123456789/37";

	require_once("lib/swordappv2-php-library/swordappclient.php");

	$last_edit_uri = "http://devel.edina.ac.uk:9228/swordv2/edit/" . $item_id;

	$testsac = new SWORDAPPClient();

    print "About to delete container at " . $last_edit_uri . "\n";
    if (empty($testuser)) {
        print "As: anonymous\n";
    } else {
        print "As: " . $testuser . "\n";
    }
    try {
        $deleteresponse = $testsac->deleteContainer($last_edit_uri, $testuser, $testpw, null);
        print $last_edit_uri . " - Container successfully deleted, HTTP code 204\n";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    print "\n\n";
?>
