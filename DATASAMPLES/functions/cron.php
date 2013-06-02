<?php
	echo "Deleting temporary files ... <br/>";
	
	foreach (glob("../TMP/SQL/*.zip") as $filename) {
		unlink($filename);
	}
	
	foreach (glob("../TMP/VIDEOS/*.zip") as $filename) {
		unlink($filename);
	}
	
	echo "Temporary files deleted.";
?>