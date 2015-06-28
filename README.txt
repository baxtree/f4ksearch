Setting up the search functionanilty:

1. Copy&paste the DATASAMPLES folder into your Web root folder.

2. Create a cron job to execute cron.php, which will delete all the ZIP files inside the /DATASAMPLES/TMP/SQL and /DATASAMPLES/TMP/VIDEOS folders at 5:00 AM every day.

5 * * * * /usr/bin/curl --silent --compressed http://REPLACE_THIS_WITH_YOUR_WEB_ROOT/DATASAMPLES/functions/cron.php

3. Video/CSV file naming conventions:

siteN_cameraN_YYYYMMDDHHMM.flv

siteN_cameraN_YYYYMMDDHHMM.csv

site1: NPP
site2: HoBiHu harbour
site3: Lanyu/Orchid Island
site4: Kenting Harbour

camera1, camera2, camera3 and camera4

YYYYMMDDHHMM denotes the datetime of the start-shooting time of each video clip.

4. /DATASAMPLES/datashare_client.php

By dereferencing the above URL, a single item will be created in the Fish4Knowledge collection at http://devel.edina.ac.uk:9228/handle/123456789/1 based on the ZIP file (conpressed CSV), the FLV file and the ATOM for in the /DATASAMPLES/datashare folder. This file was designed to sever the purpose of testing DataShare devel.

5. /DATASAMPLES/private/datashare_uploader.php

username: *****************
password: *****************

By dereferencing the above URL, all the files under /DATASAMPLES/SQL, /DATASAMPLES/VIDEOS and /DATASAMPLES/METADATA will be scanned, packaged and submitted to DataShare. During the submission, uploading the above files will be logged and stored in the file at /DATASAMPLES/logs/uploadlog.html which can be checked later in order to discover any missing/malformed files and fix and resubmit them later.


6. Workflow example


7. TODOs

A temporary date picker is currently used for testing the "Full Day" search at /DATASAMPLES/search.html and it will be removed in the future and a default date will be applied behind the scene.
