#!/bin/bash

function clearLastLine() {
    tput cuu 1 && tput el
}

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

echo
read -p "Do you want search-replace all HTTP:// to HTTPS:// (y/n)? " run_search_replace

clear

echo
echo "\033[31m\033[1mThe migration is running, do not abort! You will get a success message when migration is completed.\033[0m"

# Color scheme
echo "\033[39m\033 - Migrating color scheme…\033"

request_url=$site_url
request_url+="?migrate-colors=true"
curl $request_url -sS > /dev/null

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

# Https
case ${run_search_replace:0:1} in
    y|Y )
        echo "\033[39m\033 - Replaceing http://${request_url} with https://${request_url}…\033"
        wp search-replace 'http://${request_url}' 'https://${request_url}' --skip-columns=guid --network
    ;;
esac

# Small image detector
case ${run_small_img_detector:0:1} in
    y|Y )
        echo "\033[39m\033 - Detecting small images…\033"
        request_url=$site_url
        request_url+="?small-image-detector=true"
        curl $request_url -sS > /dev/null
    ;;
esac

# SEO data
echo "\033[39m\033 - Migrating All in one SEO data to The SEO Framework…\033[0m"

echo "\033[39m\033   x. Installing SEO Data Transporter plugin…\033[0m"
wp plugin install seo-data-transporter --activate-network --quiet
echo "\033[39m\033   x. Installation done, plugin activated.\033[0m"

echo
echo "\033[95m\033   MANUAL ACTIONS REQUIRED: You need to manually run the SEO Data Transporter process now.\033[0m"
echo
echo "\033[95m\033   1. Go to http://${request_url}/wp-admin/tools.php?page=seodt\033[0m"
echo "\033[95m\033   2. Select from \"All in One SEO Pack\" to \"Genesis\".\033[0m"
echo "\033[95m\033   3. Click the \"Analyze\" button and check the results.\033[0m"
echo "\033[95m\033   4. Click the \"Convert\" button to run the migration.\033[0m"
echo

read -n 1 -s -p "  Press any key when done"
clearLastLine
echo
clearLastLine
echo
clearLastLine
echo

echo "\033[32m\033   SEO migration marked as completed.\033[0m "
echo

echo -e "\r\033[39m\033   x. Uninstalling SEO Data Transporter plugin…\033"
wp plugin deactivate seo-data-transporter --network --uninstall --quiet

# Done
echo
echo "\033[32m\033[1mAll done! Woho!\033[0m "