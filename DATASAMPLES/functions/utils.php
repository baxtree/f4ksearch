<?php
	function matched($filename, $sites, $cameras, $startdate, $stopdate) {
		// echo $startdate->format("Y/m/d H:i:s") . " " . $stopdate->format("Y/m/d H:i:s");
		$metas = explode("_", basename($filename));
		// echo "site: " . $site;
		if (array_search(strtolower($metas[0]), $sites) !== false) {
			// echo "site matched";
			if (array_search(strtolower($metas[1]), $cameras) !== false) {
				// echo "camera matched";
				$dateStr = explode(".", $metas[2]);
				$date = DateTime::createFromFormat('YmdHi', $dateStr[0]);
				// echo $date->format("Y/m/d H:i:s");
				if ($date >= $startdate && $date <= $stopdate) {
					// echo "datetime matched";
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
	
	function newmatched($filename, $sitesncameras, $startdate, $stopdate) {
		// echo $startdate->format("Y/m/d H:i:s") . " " . $stopdate->format("Y/m/d H:i:s");
		$metas = explode("_", basename($filename));
		// echo "site: " . $site;
		if (array_search(strtolower($metas[0] . "-" . $metas[1]), $sitesncameras) !== false) {
			// echo "site & camera matched";
			$dateStr = explode(".", $metas[2]);
			$date = DateTime::createFromFormat('YmdHi', $dateStr[0]);
			// echo $date->format("Y/m/d H:i:s");
			if ($date >= $startdate && $date <= $stopdate) {
				// echo "datetime matched";
				return true;
			}
			else {
				return false;
			}
		
		}
		else {
			return false;
		}
	}
?>