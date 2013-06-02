<?php
	
	require_once("utils.php");

	$startdate = new DateTime(DateTime::createFromFormat("d/m/Y", $_GET["startday"])->format("Y-m-d") . " 00:00:00");
	$stopdate = new DateTime(DateTime::createFromFormat("d/m/Y", $_GET["stopday"])->format("Y-m-d") . " 23:00:00");
	// $sites = $_GET["site"];
	// 	$cameras = $_GET["cameras"];
	$sitesncameras = $_GET["sitencamera"];
	
	/*
	echo "start date: $startdate";
	echo "stop date: $stopdate";
	echo "site: $site";
	
	foreach($cameras as $camera) {
		echo $camera;
	}
*/
	require(dirname(__FILE__) . "/../templates/_header.php");
	
	echo "<tr><td valign='top' style='width: 700px'><h3>Search Results (first 50 results listed)</h3></tr>";
	
	$videofiles = array();
	$csvfiles = array();
	
	$counter = 0;
	$totalvideosize = 0;
	$totalcsvsize = 0;
	
	foreach (glob("../VIDEOS/ALLYEARS/*.flv") as $filename) {
		if (newmatched($filename, $sitesncameras, $startdate, $stopdate)) {
		// if (matched($filename, $sites, $cameras, $startdate, $stopdate)) {
			// echo "matched!<br/>";
			if ($counter <= 50) {
		//		echo "counter " . $counter; 
				$counter++;
				array_push($videofiles, $filename);
				$totalvideosize += filesize($filename);
				echo "<tr class='filename'><td><a href='$filename'>" . $counter . ". " . basename($filename) . "</a> (" . number_format(filesize($filename)/1024, 3) .  " KBs)</td></tr>";
			}
		}
	}
		
	if ($counter == 0) {
		echo "<tr><td>No CSV file found.</td></tr>";
	}

	
	echo "<tr/><tr/>";
	
	$counter = 0;
	
	foreach (glob("../SQL/ALLYEARS/*.csv") as $filename) {
		if (newmatched($filename, $sitesncameras, $startdate, $stopdate)) {
		// if (matched($filename, $sites, $cameras, $startdate, $stopdate)) {
			// echo "matched!<br/>";
			if ($counter <= 50) {
			// echo "counter " . $counter; 
				$counter++;
				array_push($csvfiles, $filename);
				$totalcsvsize += filesize($filename);
				echo "<tr class='filename'><td><a href='$filename'>" . $counter . ". " . basename($filename) . "</a> (" . number_format(filesize($filename)/1024, 3) .  " KBs)</td></tr>";
			}
		}			
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
		echo "	<input type='hidden' value='ay' name='prefix' />";
		echo "	<input type='submit' value='Download as ZIPs' />";	
		echo "</form></td></tr>";
		echo "<tr><td>(Note: " . number_format($totalvideosize/1048576, 3) . " MBs of FLV files and " . number_format($totalcsvsize/1048576, 3) . " MBs of CSV files will be downloaded after decompression.)</td></tr>";
	}
	
	require(dirname(__FILE__) . "/../templates/_footer.php");
?>