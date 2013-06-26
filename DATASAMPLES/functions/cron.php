<?php
/*
 * Author: Xi Bai
 * This file is called by the /cronjob for periodically clearing all the temporary downloadable ZIP files in the /DATASAMPLES/TMP folder.
 */
	echo "Deleting temporary files ... <br/>";
	
	foreach (glob("../TMP/SQL/*.zip") as $filename) {
		unlink($filename);
	}
	
	foreach (glob("../TMP/VIDEOS/*.zip") as $filename) {
		unlink($filename);
	}
	
	echo "Temporary files deleted.";
?>