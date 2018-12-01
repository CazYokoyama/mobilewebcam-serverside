#!/bin/sh
#
# delete old photos
#
# copyright(c) 2018 Caz Yokoyama, caz@caztech.com
#

TOP_DIR=/srv/www-html/html/mobilewebcam
PHOTO_DIR=archive
declare -i KEEP=10
declare -i daysago=15

while [ ${daysago} -gt ${KEEP} ]; do
    day=`date --date="${daysago} days ago" +%Y-%m-%d`
    echo delete ${TOP_DIR}/*/${PHOTO_DIR}/${day}
    sudo -u apache rm -rf ${TOP_DIR}/*/${PHOTO_DIR}/${day}
    echo $((daysago--)) >/dev/null
done

exit 0
