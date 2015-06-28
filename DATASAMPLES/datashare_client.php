<?php
/*
 * This file was designed to sever the purpose of testing DataShare devel by creating a single item based on the ZIP file (conpressed CSV), the FLV file and the ATOM for in the /DATASAMPLES/datashare folder.
 */
    // Test the V2 PHP client implementation using the Simple SWORD Server (SSS)

    // The collection URL on DataShare dev
    $dsdevcollecionurl = "http://devel.edina.ac.uk:9228/handle/123456789/1";

	// The URL of the service document
	$testurl = "http://devel.edina.ac.uk:9228/swordv2/servicedocument";

	// The user (if required)
	$testuser = "xi.bai@ed.ac.uk";

	// The password of the user (if required)
	$testpw = "*****************";

	// The on-behalf-of user (if required)
	//$testobo = "user@swordapp.com";

	// The URL of the example deposit collection
	$testdepositurl = "http://devel.edina.ac.uk:9228/swordv2/collection/123456789/37";

	// The test atom entry to deposit
	$testatomentry = "datashare/site1_camera2_201202051210.atom";

	// The second test atom entry to deposit
/* 	$testatomentry2 = "test-files/atom_multipart/atom2"; */

	// The test atom multipart file to deposit
/* 	$testmultipart = "test-files/atom_multipart_package"; */

	// The second test file to deposit
/* 	$testmultipart2 = "test-files/atom_multipart_package2"; */

	$testvideofile = "datashare/site1_camera2_201202051210.flv";

	$testcsvfile = "datashare/site1_camera2_201202051210.zip";

	$testvideotype = "video/mp4";

	$testcsvtype = "application/zip";

	// The test content zip file to deposit
/* 	$testzipcontentfile = "test-files/atom_multipart_package2.zip"; */

    // A plain content file
    $testextrafile = "lib/swordappv2-php-library/test/test-files/swordlogo.jpg";

    // The file type of the extra file
    $testextrafiletype = "application/zip";

	// The content type of the test file
/* 	$testcontenttype = "application/zip"; */

	// The packaging format of the test file
/* 	$testpackaging = "http://purl.org/net/sword/package/SimpleZip"; */

	$videopackaging = "http://purl.org/net/sword/package/Binary";

	$csvpackaging = "http://purl.org/net/sword/package/Binary";

	$zippackaging = "http://purl.org/net/sword/package/SimpleZip";

	require_once("lib/swordappv2-php-library/swordappclient.php");

    $testsac = new SWORDAPPClient();

     	print "About to add package (" . $testcsvfile . ") to " . $testdepositurl . "\n";

        if (empty($testuser)) {
            print "As: anonymous\n";
        } else {
            print "As: " . $testuser . "\n";
        }
/*         $testdr = $testsac->depositMultipart($testdepositurl, $testuser, $testpw, null, "test-files/atom_multipart_package", false); */
        $testdr = $testsac->deposit($testdepositurl, $testuser, $testpw, null, $testcsvfile, $csvpackaging, $testcsvtype, true);
        print "Received HTTP status code: " . $testdr->sac_status .
              " (" . $testdr->sac_statusmessage . ")\n";

        if (($testdr->sac_status >= 200) || ($testdr->sac_status < 300)) {
            $testdr->toString();
        }

        print "\n\n";

        $edit_iri = $testdr->sac_edit_iri;
        $cont_iri = $testdr->sac_content_src;
        $edit_media = $testdr->sac_edit_media_iri;

        print "About to add file (" . $testvideofile . ") to " . $edit_media . "\n";
        if (empty($testuser)) {
            print "As: anonymous\n";
        } else {
            print "As: " . $testuser . "\n";
        }
/*         $testdr = $testsac->addExtraPackage($edit_iri, $testuser, $testpw, null, $testvideofile, $videopackaging, $testvideotype, true); */
 		$testdr = $testsac->addExtraFileToMediaResource($edit_media, $testuser, $testpw, null, $testvideofile, $testvideotype, false);

        print "Received HTTP status code: " . $testdr->sac_status .
              " (" . $testdr->sac_statusmessage . ")\n";

        if (($testdr->sac_status >= 200) || ($testdr->sac_status < 300)) {
            $testdr->toString();
        }

        print "\n\n";




/*
        print "About to deposit (" . $testvideofile . ") to " . $edit_iri . "\n";

        if (empty($testuser)) {
            print "As: anonymous\n";
        } else {
            print "As: " . $testuser . "\n";
        }
        $testdr = $testsac->deposit($edit_iri, $testuser, $testpw, null, $testvideofile, $videopackaging, $testvideotype, true);
        $testdr = $testsac->addExtraMultipartPackage($edit_iri, $testuser, $testpw, null, "test-files/atom_multipart_package" , false);
        print "Received HTTP status code: " . $testdr->sac_status .
              " (" . $testdr->sac_statusmessage . ")\n";

        if (($testdr->sac_status >= 200) || ($testdr->sac_status < 300)) {
            $testdr->toString();
        }
*/


		print "\n\n";


        print "About to add atom entry (" . $testatomentry . ") to " . $edit_iri . "\n";
        if (empty($testuser)) {
            print "As: anonymous\n";
        } else {
            print "As: " . $testuser . "\n";
        }
        $testdr = $testsac->addExtraAtomEntry($edit_iri, $testuser, $testpw, null, $testatomentry, false);
        print "Received HTTP status code: " . $testdr->sac_status .
              " (" . $testdr->sac_statusmessage . ")\n";

        if (($testdr->sac_status >= 200) || ($testdr->sac_status < 300)) {
            $testdr->toString();
        }

        print "\n\n";


?>
