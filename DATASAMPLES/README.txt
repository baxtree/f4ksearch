1. create a cron job to execute cron.php, e.g.,

5 * * * * /usr/bin/curl --silent --compressed http://localhost:8888/DATASAMPLES/functions/cron.php

2. File naming conventions:

siteN_cameraN_YYYYMMDDHHMM_YYYYMMDDHHMM_YYYYMMDDHHMM.flv

siteN_cameraN_YYYYMMDDHHMM_YYYYMMDDHHMM_YYYYMMDDHHMM.csv

site1: NPP
site2: HoBiHu harbour
site3: Lanyu/Orchid Island
site4: Kenting Harbour