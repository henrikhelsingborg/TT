#!/bin/bash

clear

echo
echo "\033[35m\033[1m##########\033[0m"
echo
echo "\033[35m\033[1mHi there!\033[0m"
echo
echo "\033[35m\033[1mSo, it's time to migrate old Helsingborg.se to new Helsingborg.se?\033[0m"
echo
echo "\033[35m\033[1mI will be your guide on this exciting journey. Please follow the steps and the migration will hopefully be a smooth process.\033[0m"
echo
echo "\033[35m\033[1m##########\033[0m"
echo

echo "\033[34m\033[1mEnter the url for the new Helsingborg.se site to continue:\033[0m "
read site_url

echo
read -p "Do you want to run the small image detector (y/n)? " run_small_img_detector

clear

echo
echo "\033[31m\033[1mThe migration is running, do not abort! You will get a success message when migration is completed.\033[0m"

# Widgets, shortcodes and templates
echo "\033[39m\033 - Migrating widgets, shortcodes and templates…\033"

request_url=$site_url
request_url+="?migrate=yes-please"
curl $request_url -sS > /dev/null

# Post types
echo "\033[39m\033 - Updating post types…\033"

request_url=$site_url
request_url+="?change-post-types=step-1"
curl $request_url -sS > /dev/null

request_url=$site_url
request_url+="?change-post-types=step-2"
curl $request_url -sS > /dev/null

# Small image detector
case ${run_small_img_detector:0:1} in
    y|Y )
        echo "\033[39m\033 - Detecting small images…\033"
        request_url=$site_url
        request_url+="?small-image-detector=true"
        curl $request_url -sS > /dev/null
    ;;
esac

# Done
echo
echo "\033[32m\033[1mAll done! Woho!\033[0m "
