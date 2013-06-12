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
	
	function download_time($file) {
	    if(!function_exists("sec_format")) {
	        function sec_format($seconds) {
	            $units = array(    "day|s"=>86400,
	                            "hour|s"=>3600,
	                            "minute|s"=>60,
	                            "second|s"=>1
	                             );
	            if($seconds < 1) {
	                return "< 1second";
	            } else {
	                $show = FALSE;
	                $ausg = "";
	                foreach($units as $key=>$value) {
	                    $t = round($seconds/$value);
	                    $seconds = $seconds%$value;
	                    list($s, $pl) = explode("|", $key);
	                    if($t > 0 || $show) {
	                        if($t == 1) {
	                            $ausg .= $t." ".$s.", ";
	                        } else {
	                            $ausg .= $t." ".$s.$pl.", ";
	                        }
	                        $show = TRUE;
	                    }
	                }
	                $ausg = substr($ausg, 0, strlen($ausg)-2);
	                return $ausg;
	            }
	        }
	    }
	    $values = array("DSL"=>768,
	                    "ISDN"=>128,
	                    "Modem"=>56.6
	                      );
	    $size = filesize($file);
	    $ausg = round($size/(1024), 0)." KB<br />";
	    $size *= 8;
	    foreach($values as $key=>$value) {
	        $time = sec_format($size/($value*1024));
	        $ausg .= $time." @ ".$value." kBit (".$key.")<br />";
	    }
	    return $ausg;
} 
?>