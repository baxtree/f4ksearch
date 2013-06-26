<?php
/*
 * This file is used for search video files and CSV files from the ALLYEARS folder based on a user's inputs including the start date, the stop date and the site & camera. Note that a temporary date picker is currently used for testing the "Full Day" search at /DATASAMPLES/search.html and it will be removed in the future and a default date will be applied behind the scene. 
 */
	require(dirname(__FILE__) . "/../templates/_header.php");

	require_once("utils.php");
	if (!isset($_GET["starttime"]) || !isset($_GET["stoptime"]) || !isset($_GET["sitencamera"])) {
		die("<tr><td valign='top' style='width: 700px'><h3>Input error. Start Time, Stop Time or Sites &amp; Cameras is not valid. </h3></tr><tr class='backtosearch'><td><a href='../search.html'>Back to Search</a></td></tr>");
	}

	
	$startdate = new DateTime(DateTime::createFromFormat("d/m/Y", $_GET["fulldate"])->format("m/d/Y") . " " . $_GET["starttime"]);
	$stopdate = new DateTime(DateTime::createFromFormat("d/m/Y", $_GET["fulldate"])->format("m/d/Y") . " " . $_GET["stoptime"]);
	// $sites = $_GET["site"];
	// 	$cameras = $_GET["cameras"];
	$sitesncameras = $_GET["sitencamera"];

	echo "<tr><td valign='top' style='width: 700px'><h3>Search Results (first 50 results listed)</h3></tr>";
	
	$videofiles = array();
	$csvfiles = array();
	
	$counter = 0;
	$totalvideosize = 0;
	$totalcsvsize = 0;
	
	echo "<tr><td><h4>Videos:</h4></td></tr>";
	
	foreach (glob("../VIDEOS/FULLDAY/*.flv") as $filename) {
		if (newmatched($filename, $sitesncameras, $startdate, $stopdate)) {
		// if (matched($filename, $sites, $cameras, $startdate, $stopdate)) {
			// echo "matched!<br/>";
			
//				echo "counter " . $counter; 
			$counter++;
			array_push($videofiles, $filename);
			$totalvideosize += filesize($filename);
			if ($counter <= 50) {
				echo "<tr class='filename'><td><a href='$filename'>" . $counter . ". " . basename($filename) . "</a> (" . number_format(filesize($filename)/1024, 3) .  " KBs)</td></tr>";
			}
		}
	}
	
	if ($counter > 50) {
		echo "<tr><td>...</td></tr>";
	}
		
	if ($counter == 0) {
		echo "<tr><td>No CSV file found.</td></tr>";
	}
	
	echo "<tr/><tr/>";
	
	echo "<tr><td><h4>CSVs:</h4></td></tr>";
	
	$counter = 0;
	
	foreach (glob("../SQL/FULLDAY/*.csv") as $filename) {
		if (newmatched($filename, $sitesncameras, $startdate, $stopdate)) {
		// if (matched($filename, $sites, $cameras, $startdate, $stopdate)) {
			// echo "matched!<br/>";

			// echo "counter " . $counter; 
			$counter++;
			array_push($csvfiles, $filename);
			$totalcsvsize += filesize($filename);
			if ($counter <= 50) {
				echo "<tr class='filename'><td><a href='$filename'>" . $counter . ". " . basename($filename) . "</a> (" . number_format(filesize($filename)/1024, 3) .  " KBs)</td></tr>";
			}
		}			
	}
	
	if ($counter > 50) {
		echo "<tr><td>...</td></tr>";
	}

	if ($counter == 0) {
		echo "<tr><td>No VIDEO file found.</td></tr>";
	}
	
	echo "<tr/><tr/>";
	
	$videoencoded = base64_encode(serialize($videofiles));
	$cvsencoded = base64_encode(serialize($csvfiles));
	
	if ($counter != 0) {
		echo "<tr><td><form method='post' action='download.php' enctype='application/x-www-form-urlencoded'>";
		echo "	<input type='hidden' value='$videoencoded' name='videofiles' />";
		echo "	<input type='hidden' value='$cvsencoded' name='csvfiles' />";
		echo "	<input type='hidden' value='fd' name='prefix' />";
		echo "	<input type='submit' value='Download as ZIPs' />";	
		echo "</form></td></tr>";
		echo "<tr><td>(Note: " . number_format($totalvideosize/1048576, 3) . " MBs of FLV files and " . number_format($totalcsvsize/1048576, 3) . " MBs of CSV files will be downloaded after decompressions.)</td></tr>";
		echo "<tr/><tr/>";
		echo "<tr class='backtosearch'><td><a href='../search.html'>Back to Search</a></td></tr>";
	}
	
	require(dirname(__FILE__) . "/../templates/_footer.php");
?>