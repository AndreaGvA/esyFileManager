#!/bin/bash

# SmartGaP s.r.l | andrea@smartgap.it | www.smartgap.it
rm /tmp/quotas
cat /etc/passwd | grep "/clients" | cut -d: -f1 | while read user
do
   QUOTA=`quota -u $user | tail -n 1 | awk '{print $4}'`
   FREE=`quota -u $user | tail -n 1 | awk '{print $2}'`
   echo "$user $QUOTA $FREE" >> /tmp/quotas
done