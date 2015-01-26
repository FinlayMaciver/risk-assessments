#!/bin/bash
rsync -ave ssh --exclude='*bzr*' --exclude='*globals.php*' --exclude="*dompdf*" /home/billy/tidied/code/MongoDB/risk root@web.eng.gla.ac.uk:/var/www/html/tools/

