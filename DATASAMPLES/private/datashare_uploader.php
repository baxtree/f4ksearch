<?php
/*
 * This file is used for scanning and depositing all the files under /DATASAMPLES/SQL, /DATASAMPLES/VIDEOS and /DATASAMPLES/METADATA to DataShare.
 */
	$full_day_video = dirname(__FILE__) . "/../VIDEOS/FULLDAY";
	$all_year_video = dirname(__FILE__) . "/../VIDEOS/ALLYEARS";
	$full_day_csv = dirname(__FILE__) . "/../SQL/FULLDAY";
	$all_year_csv = dirname(__FILE__) . "/../SQL/ALLYEARS";
	$full_day_atom = dirname(__FILE__) . "/../METADATA/FULLDAY";
	$all_year_atom = dirname(__FILE__) . "/../METADATA/ALLYEARS";
	$upload_log = dirname(__FILE__) . "/../logs/uploadlog.html";

	$dsdevcollecionurl = "http://devel.edina.ac.uk:9228/handle/123456789/1";
	$ds_url = "http://devel.edina.ac.uk:9228/swordv2/servicedocument";
	$ds_user = "xi.bai@ed.ac.uk";
	$ds_pw = "*****************";
	$ds_depositurl = "http://devel.edina.ac.uk:9228/swordv2/collection/123456789/37";
	$ds_videotype = "video/mp4";
	$ds_csvtype = "application/zip";
	$videopackaging = "http://purl.org/net/sword/package/Binary";
	$csvpackaging = "http://purl.org/net/sword/package/Binary";

	$log = "";

	require_once("../lib/swordappv2-php-library/swordappclient.php");

	$ds_sac = new SWORDAPPClient();

	foreach (glob($all_year_csv . "/*.zip") as $videofile) {
		$itemname = explode(".",  basename($videofile));
		$csvfile = $all_year_csv . "/" . $itemname[0] . ".zip";
		$videofile = $all_year_video . "/" . $itemname[0] . ".flv";
		$atomentry = $all_year_atom . "/" . $itemname[0] . ".atom";
		$filemissing = false;
		if (!file_exists($csvfile)) {
/* 			trigger_error("CSV file not found [" . $csvfile . "]", E_USER_WARNING); */
			$log .= "<b>CSV file not found</b> [" . $csvfile . "] <br/>";
			$filemissing = true;
		}
		if (!file_exists($videofile)) {
/* 			trigger_error("VIDEO file not found [" . $videofile . "]", E_USER_WARNING); */
			$log .= "<b>VIDEO file not found</b> [" . $videofile . "] <br/>";
			$filemissing = true;
		}
		if (!file_exists($atomentry)) {
/* 			trigger_error("ATOM file not found [" . $atomentry . "]", E_USER_WARNING); */
			$log .= "<b>ATOM file not found</b> [" . $atomentry . "] <br/>";
			$filemissing = true;
		}
		if($filemissing) {
			continue;
		}
		$log .= "About to add package (" . $csvfile . ") to " . $ds_depositurl . "\n";

        if (empty($ds_user)) {
            $log .= "As: anonymous\n<br/>";
        } else {
/*             $log .= "As: " . $ds_user . "\n<br/>"; */
        }
        $ds_dr = $ds_sac->deposit($ds_depositurl, $ds_user, $ds_pw, null, $csvfile, $csvpackaging, $ds_csvtype, true);
        $log .= "Received HTTP status code: " . $ds_dr->sac_status .
              " (" . $ds_dr->sac_statusmessage . ")\n<br/>";

        if (($ds_dr->sac_status >= 200) || ($ds_dr->sac_status < 300)) {
/*             $ds_dr->toString(); */
        }

        $log .= "\n\n";

        $edit_iri = $ds_dr->sac_edit_iri;
        $cont_iri = $ds_dr->sac_content_src;
        $edit_media = $ds_dr->sac_edit_media_iri;

        $log .= "About to add file (" . $videofile . ") to " . $edit_media . "\n";
        if (empty($ds_user)) {
            $log .=  "As: anonymous\n<br/>";
        } else {
/*             $log .=  "As: " . $ds_user . "\n<br/>"; */
        }
 		$ds_dr = $ds_sac->addExtraFileToMediaResource($edit_media, $ds_user, $ds_pw, null, $videofile, $ds_videotype, false);

        $log .=  "Received HTTP status code: " . $ds_dr->sac_status .
              " (" . $ds_dr->sac_statusmessage . ")\n<br/>";

        if (($ds_dr->sac_status >= 200) || ($ds_dr->sac_status < 300)) {
/*             $ds_dr->toString(); */
        }

        $log .=  "\n\n";

        $log .=  "About to add atom entry (" . $atomentry . ") to " . $edit_iri . "\n";
        if (empty($ds_user)) {
            $log .=  "As: anonymous\n<br/>";
        } else {
/*             $log .=  "As: " . $ds_user . "\n<br/>"; */
        }
        $ds_dr = $ds_sac->addExtraAtomEntry($edit_iri, $ds_user, $ds_pw, null, $atomentry, false);
        $log .=  "Received HTTP status code: " . $ds_dr->sac_status .
              " (" . $ds_dr->sac_statusmessage . ")\n<br/>";

        if (($ds_dr->sac_status >= 200) || ($ds_dr->sac_status < 300)) {
/*             $ds_dr->toString(); */
        }

        $log .=  "\n\n";

	}


	foreach (glob($full_day_csv . "/*.zip") as $videofile) {
		$itemname = explode(".",  basename($videofile));
		$csvfile = $full_day_csv . "/" . $itemname[0] . ".zip";
		$videofile = $full_day_video . "/" . $itemname[0] . ".flv";
		$atomentry = $full_day_atom . "/" . $itemname[0] . ".atom";
		$filemissing = false;
		if (!file_exists($csvfile)) {
/* 			trigger_error("CSV file not found [" . $csvfile . "]", E_USER_WARNING); */
			$log .= "<b>CSV file not found</b> [" . $csvfile . "] <br/>";
			$filemissing = true;
		}
		if (!file_exists($videofile)) {
/* 			trigger_error("VIDEO file not found [" . $videofile . "]", E_USER_WARNING); */
			$log .= "<b>VIDEO file not found</b> [" . $videofile . "] <br/>";
			$filemissing = true;
		}
		if (!file_exists($atomentry)) {
/* 			trigger_error("ATOM file not found [" . $atomentry . "]", E_USER_WARNING); */
			$log .= "<b>ATOM file not found</b> [" . $atomentry . "] <br/>";
			$filemissing = true;
		}
		if($filemissing) {
			continue;
		}
		$log .=  "About to add package (" . $csvfile . ") to " . $ds_depositurl . "\n";

        if (empty($ds_user)) {
            $log .=  "As: anonymous\n<br/>";
        } else {
/*             $log .=  "As: " . $ds_user . "\n<br/>"; */
        }
        $ds_dr = $ds_sac->deposit($ds_depositurl, $ds_user, $ds_pw, null, $csvfile, $csvpackaging, $ds_csvtype, true);
        $log .=  "Received HTTP status code: " . $ds_dr->sac_status .
              " (" . $ds_dr->sac_statusmessage . ")\n<br/>";

        if (($ds_dr->sac_status >= 200) || ($ds_dr->sac_status < 300)) {
/*             $ds_dr->toString(); */
        }

        $log .=  "\n<br/>\n<br/>";

        $edit_iri = $ds_dr->sac_edit_iri;
        $cont_iri = $ds_dr->sac_content_src;
        $edit_media = $ds_dr->sac_edit_media_iri;

        $log .=  "About to add file (" . $videofile . ") to " . $edit_media . "\n";
        if (empty($ds_user)) {
            $log .=  "As: anonymous\n<br/>";
        } else {
/*             $log .=  "As: " . $ds_user . "\n<br/>"; */
        }
 		$ds_dr = $ds_sac->addExtraFileToMediaResource($edit_media, $ds_user, $ds_pw, null, $videofile, $ds_videotype, false);

        $log .=  "Received HTTP status code: " . $ds_dr->sac_status .
              " (" . $ds_dr->sac_statusmessage . ")\n<br/>";

        if (($ds_dr->sac_status >= 200) || ($ds_dr->sac_status < 300)) {
/*             $ds_dr->toString(); */
        }

        $log .=  "\n<br/>\n<br/>";

        $log .=  "About to add atom entry (" . $atomentry . ") to " . $edit_iri . "\n";
        if (empty($ds_user)) {
            $log .=  "As: anonymous\n<br/>";
        } else {
/*             $log .=  "As: " . $ds_user . "\n<br/>"; */
        }
        $ds_dr = $ds_sac->addExtraAtomEntry($edit_iri, $ds_user, $ds_pw, null, $atomentry, false);
        $log .=  "Received HTTP status code: " . $ds_dr->sac_status .
              " (" . $ds_dr->sac_statusmessage . ")\n<br/>";

        if (($ds_dr->sac_status >= 200) || ($ds_dr->sac_status < 300)) {
/*             $ds_dr->toString(); */
        }

        $log .=  "\n<br/>\n<br/>";

	}

	file_put_contents($upload_log, $log, LOCK_EX);
	echo $log;
?>
