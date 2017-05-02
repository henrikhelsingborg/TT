#!/bin/bash

echo "\033[34m\033[1mDatabase name:\033[0m "
read db_name

echo "\033[34m\033[1mDatabase user:\033[0m "
read db_user

echo "\033[34m\033[1mDatabase password:\033[0m "
read db_password

total_result=`mysql $db_name -u $db_user -p$db_password -s -e "SELECT COUNT(*) FROM hbg_blogs;"`

iterate_num=0
current_num=0

mysql $db_name -u $db_user -p$db_password -e "SELECT domain, path FROM hbg_blogs" | while read domain path; do
    if (( $iterate_num > 0 )); then
        current_num=$((current_num+1))
        echo "Migrating ($current_num/$total_result) http://$domain$path"
        sh migrate-single.sh --site_url=http://$domain$path --no-seo
    fi

    iterate_num=$((iterate_num+1))
done

echo
echo "\033[32m\033[1mMultisite migration done! Woho!\033[0m "
