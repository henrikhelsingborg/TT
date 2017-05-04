#!/bin/bash

run_seo_migration="y"
use_params="n"

while [ $# -gt 0 ]; do
    case "$1" in
        --site_url=*)
            use_params="y"
            site_url="${1#*=}"
        ;;

        --img_detector) run_small_img_detector="y" ;;
        --search_replace) run_search_replace="y" ;;
        --network_op) run_network_op="y" ;;
        --no-seo) run_seo_migration="n" ;;
        --school) is_school="y" ;;

        *)
        printf "*******************************\n"
        printf "*   Error: Invalid argument   *\n"
        printf "*******************************\n"
        exit 1
        esac
    shift
done

if [ "$use_params" != "y" ]; then
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

    echo "Clearing caches…"
    echo

    service apache2 restart
    service varnish restart
    service memcached restart
    service redis-server restart
fi

if [ -z "$site_url" ]; then
    echo "\033[34m\033[1mEnter the url for the new Helsingborg.se site to continue:\033[0m "
    read site_url
fi

if [ "$use_params" != "y" ] && [ -z "$is_school" ]; then
    echo
    read -p "Is this a school site (y/n)? " is_school
fi

if [ "$use_params" != "y" ] && [ -z "$run_small_img_detector" ]; then
    echo
    read -p "Do you want to run the small image detector (y/n)? " run_small_img_detector
fi

if [ "$use_params" != "y" ] && [ -z "$run_search_replace" ]; then
    echo
    read -p "Do you want search-replace all HTTP:// to HTTPS:// (y/n)? " run_search_replace
fi

if [ "$use_params" != "y" ] && [ -z "$run_network_op" ]; then
    echo
    read -p "Do you want to run network-wide operations (setting Google Analytics id and search/replace https to http for embeds) (y/n)? " run_network_op
fi

if [ "$use_params" != "y" ]; then
clear
fi

echo
echo "\033[31m\033[1mThe migration is running, do not abort! You will get a success message when migration is completed.\033[0m"

# Logos
echo "\033[39m\033 - Migrating logotypes…\033"

request_url="${site_url}?migrate-logotype=true"
curl $request_url -sS > /dev/null

# Color scheme
echo "\033[39m\033 - Migrating color scheme…\033"

request_url="${site_url}?migrate-colors=true"
curl $request_url -sS > /dev/null

# Theme options
echo "\033[39m\033 - Configurating the theme options…\033"

request_url="${site_url}?migrate-theme-options=true"
curl $request_url -sS > /dev/null

# School options
case $is_school in
    y|Y )
        echo "\033[39m\033 - Configurating school theme options…\033"

        request_url="${site_url}?migrate-school-options=true"
        curl $request_url -sS > /dev/null
    ;;
esac

# Modularity options
echo "\033[39m\033 - Configurating Modularity options…\033"

request_url="${site_url}?migrate-modularity-options=true"
curl $request_url -sS > /dev/null

# Modularity options
echo "\033[39m\033 - Configurating Event API integration…\033"

request_url="${site_url}?migrate-event-integration=true"
curl $request_url -sS > /dev/null

# Widgets, shortcodes and templates
echo "\033[39m\033 - Migrating posts, shortcodes, templates and converting widgets to modules…\033"

request_url="${site_url}?migrate=yes-please"
curl $request_url -sS > /dev/null

# Post types
if [ "$is_school" != "y"]; then
        echo "\033[39m\033 - Updating post types…\033"

        request_url="${site_url}?change-post-types=step-1"
        curl $request_url -sS > /dev/null

        request_url="${site_url}?change-post-types=step-2"
        curl $request_url -sS > /dev/null
    ;;
fi

# Https
case $run_search_replace in
    y|Y )
        echo "\033[39m\033 - Replaceing http://${request_url} with https://${request_url}…\033"
        wp search-replace 'http://${request_url}' 'https://${request_url}' --skip-columns=guid --network --allow-root
    ;;
esac

# Small image detector
case $run_small_img_detector in
    y|Y )
        echo "\033[39m\033 - Detecting small images…\033"
        request_url="${site_url}?small-image-detector=true"
        curl $request_url -sS > /dev/null
    ;;
esac

case $run_network_op in
    y|Y )
        # Iframe/embed http to https
        echo "\033[39m\033 - SSL on iframes, scripts and links…\033[0m"
        wp search-replace '(<(?:iframe|script|link)[^>]*(?:src|href)=[\\ \s\"]*?)(http)(:.*?>)' '${1}${2}s${3}' hbg_*post* --include-columns=meta_value,post_content --regex --regex-flags='i' --network --allow-root

        # Google Analytics
        echo "\033[39m\033 - Setting Google Analytics id…\033[0m"
        request_url="${site_url}?save-analytics=true"
        curl $request_url -sS > /dev/null
    ;;
esac

echo "Clearing caches again…"
service memcached restart
service redis-server restart

# SEO data
case $run_seo_migration in
    y|Y)
        echo "\033[39m\033 - Migrating All in one SEO data to The SEO Framework…\033[0m"

        echo "\033[39m\033   x. Installing SEO Data Transporter plugin…\033[0m"
        wp plugin install seo-data-transporter --activate-network --quiet --allow-root
        echo "\033[39m\033   x. Installation done, plugin activated.\033[0m"

        echo
        echo "\033[95m\033   MANUAL ACTIONS REQUIRED: You need to manually run the SEO Data Transporter process now.\033[0m"
        echo
        echo "\033[95m\033   1. Go to ${site_url}/wp/wp-admin/tools.php?page=seodt\033[0m"
        echo "\033[95m\033   2. Select from \"All in One SEO Pack\" to \"Genesis\".\033[0m"
        echo "\033[95m\033   3. Click the \"Analyze\" button and check the results.\033[0m"
        echo "\033[95m\033   4. Click the \"Convert\" button to run the migration.\033[0m"
        echo

        read -p "Press enter to continue" enter_to_continue
        echo

        echo "\033[32m\033   SEO migration marked as completed.\033[0m "
        echo

        echo -e "\r\033[39m\033   x. Uninstalling SEO Data Transporter plugin…\033"
        wp plugin deactivate seo-data-transporter --network --uninstall --quiet --allow-root
    ;;
esac

# Done
echo
echo "\033[32m\033[1m$site_url migrated\033[0m "
