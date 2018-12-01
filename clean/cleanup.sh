#!/bin/sh
#
# delete old photos
#
# copyright(c) 2018 Caz Yokoyama, caz@caztech.com
#

TOP_DIR=/srv/www-html/html/mobilewebcam
PHOTO_DIR=archive
KEEP=10 # days
deletestart=`date --date="${KEEP} days ago" +%Y%m%d`

for photo_dir in ${TOP_DIR}/*/${PHOTO_DIR}; do
    cd ${photo_dir}; ls -1d 20??-??-?? |\
    while read dir; do
	year=`echo ${dir} | cut -d"-" -f1`
	month=`echo ${dir} | cut -d"-" -f2`
	date=`echo ${dir} | cut -d"-" -f3`
	dir_date=${year}${month}${date}
	if [ ${dir_date} -lt ${deletestart} ]; then
	    echo delete ${photo_dir}/${dir}
	    sudo -u apache rm -rf ${photo_dir}/${dir}
	fi
    done
done

exit 0
