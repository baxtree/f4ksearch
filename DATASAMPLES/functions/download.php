<?php
	ini_set('max_execution_time', 120);
	require(dirname(__FILE__) . "/../templates/_header.php");
	$loading_time = (float) $_COOKIE["search_test_cookie"];
	$loading_size = 600.40;
	$transfer_rate = 600.40 / $loading_time;
	
	echo "<tr><td valign='top' style='width: 700px'><h3>Downloadable Datasets</h3></tr>";
	
	// print_r(glob("../VIDEOS/ALLYEARS/*.flv"));
	$videofiles = unserialize(base64_decode($_POST["videofiles"]));
	$csvfiles = unserialize(base64_decode($_POST["csvfiles"]));
	$prefix = $_POST["prefix"];
	
	$zip = new ZipArchive;
	
	$time = time();
	$videozipname = "f4k_flv_" . $prefix . "_" . $time . ".zip";
	$csvzipname = "f4k_csv_" . $prefix . "_" . $time . ".zip";
	$videoziparray = array();
	$csvziparray = array();
	
	// $csvziparray = array();
	// array_push($csvziparray, $csvzipname);
	$sizeaccumulator = 0;
	$zippartcounter = 1;
	$videozippath = "../TMP/VIDEOS/$videozipname";
	array_push($videoziparray, $videozippath);
	
	if ($zip->open($videozippath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) == true) {
		foreach ($videofiles as $videofile) {
			$sizeaccumulator += filesize($videofile);
			if($sizeaccumulator > 2000000000) { //make the maximum size of each downloadable video zip less than 2 GBs
				$zip->close();
				$zippartcounter++;
				$videozipname = "f4k_flv_" . $prefix . "_" . $time . "_part" . "$zippartcounter" . ".zip";
				$videozippath = "../TMP/VIDEOS/$videozipname";
				array_push($videoziparray, $videozippath);
				if($zip->open($videozippath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) == true) {
					$zip->addFile($videofile);
				}
			}
			else {
				$zip->addFile($videofile);
			}
		}
	}
	
	$zip->close();
	
	if (count($videofiles) != 0) {
		foreach ($videoziparray as $videozip) {
			chmod($videozip, 0775);
			echo "<tr class='download'><td><a href='$videozip'>Click to download all the videos as ZIP (file size: " . number_format(filesize($videozip)/1048576, 3) . " MBs, estimated download time: " . number_format(((filesize($videozip)/1024)/$transfer_rate)/60.0, 2) . " minutes) ...</a></td></tr>";
		}
	}
	else {
		echo "No video files to download ...";
	}
	
	$sizeaccumulator = 0;
	$zippartcounter = 1;
	$csvzippath = "../TMP/SQL/$csvzipname";
	array_push($csvziparray, $csvzippath);
	
	if ($zip->open($csvzippath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === true) {
		foreach ($csvfiles as $csvfile) {
			$sizeaccumulator += filesize($csvfile);
			if($sizeaccumulator > 2000000000) { //make the maximum size of each downloadable csv zip less than 2 GBs
				$zip->close();
				$zippartcounter++;
				$csvzipname = "f4k_flv" . $prefix . "_" . $time . "_part" . "$zippartcounter" . ".zip";
				$csvzippath = "../TMP/SQL/$csvzipname";
				array_push($csvziparray, $csvzippath);
				if ($zip->open($csvzippath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === true) {
					$zip->addFile($csvfile);
				}
			}
			else {
				$zip->addFile($csvfile);
			}
		}
	}
	
	$zip->close();
	
	if (count($csvfiles) != 0) {
		foreach ($csvziparray as $csvzip) {
			chmod($csvzippath, 0775);
			echo "<tr class='download'><td><a href='../TMP/SQL/$csvzipname'>Click to download all the CSVs as ZIP (file size: " . number_format(filesize($csvzip)/1048576, 3) . " MBs, estimated download time: " . number_format(((filesize($csvzip)/1024)/$transfer_rate)/60.0, 2) . " minutes) ...</a></td></tr>";					
		}
	}
	else {
		echo "No CSV files to download ...";
	}
	
	echo "<tr/><tr/>";
	echo "<tr class='backtosearch'><td><a href='../search.html'>Back to Search</a></td></tr>";
	
	require(dirname(__FILE__) . "/../templates/_footer.php");
?>