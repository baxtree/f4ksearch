<?php
	ini_set('max_execution_time', 120);
	require(dirname(__FILE__) . "/../templates/_header.php");
	
	echo "<tr><td valign='top' style='width: 700px'><h3>Downloadable Datasets</h3></tr>";
	
	// print_r(glob("../VIDEOS/ALLYEARS/*.flv"));
	$videofiles = unserialize(base64_decode($_POST["videofiles"]));
	$csvfiles = unserialize(base64_decode($_POST["csvfiles"]));
	$prefix = $_POST["prefix"];
	
	$zip = new ZipArchive;
	$zippartcounter = 1;
	$time = time();
	$videozipname = "f4k_flv_" . $prefix . "_" . $time . ".zip";
	$csvzipname = "f4k_csv_" . $prefix . "_" . $time . ".zip";
	$videoziparray = array();
	
	// $csvziparray = array();
	// array_push($csvziparray, $csvzipname);
	$sizeaccumulator = 0;
	
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
			echo "<tr class='download'><td><a href='$videozip'>Click to download all the videos as ZIP (" . number_format(filesize($videozip)/1048576, 3) . " MBs) ...</a></td></tr>";
		}
	}
	else {
		echo "Cannot open the ../TMP/VIDEOS/$videozipname";
	}
	

	$csvzippath = "../TMP/SQL/$csvzipname";
	
	if ($zip->open($csvzippath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === true) {
		foreach ($csvfiles as $csvfile) {
			$zip->addFile($csvfile);
		}
	}
	
	$zip->close();
	
	if (count($csvfiles) != 0) {
		chmod($csvzippath, 0775);
		echo "<tr class='download'><td><a href='../TMP/SQL/$csvzipname'>Click to download all the CSVs as ZIP (" . number_format(filesize($csvzippath)/1048576, 3) . " MBs) ...</a></td></tr>";		
	}
	else {
		echo "Cannot open the ../TMP/VIDEOS/$csvzipname";
	}
	
	echo "<tr/><tr/>";
	echo "<tr class='backtosearch'><td><a href='../search.html'>Back to Search</a></td></tr>";
	
	require(dirname(__FILE__) . "/../templates/_footer.php");
?>