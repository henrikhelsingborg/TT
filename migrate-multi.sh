#!/bin/bash

echo "\033[34m\033[1mDatabase name:\033[0m "
read db_name

echo "\033[34m\033[1mDatabase user:\033[0m "
read db_user

echo "\033[34m\033[1mDatabase password:\033[0m "
read db_password

is_school="n"
read -p "Is this a network with school sites? (y/n)? " is_school

#echo "Activating plugins (network)"
#wp plugin activate redis-cache --network --allow-root

total_result=`mysql $db_name -u $db_user -p$db_password -s -e "SELECT COUNT(*) FROM hbg_blogs;"`

iterate_num=0
current_num=0

sql="SELECT domain, path FROM hbg_blogs"
if [ "$is_school" == "y" ]; then
    sql="SELECT domain, path FROM hbg_blogs WHERE blog_id < 2"
fi

mysql $db_name -u $db_user -p$db_password -e "$sql" | while read domain path; do
    if [ "$domain" != "domain" ]; then
        current_num=$((current_num+1))
        echo "Migrating ($current_num/$total_result) http://$domain$path"

        if [ "$is_school" != "y" ]; then
            sh migrate-single.sh --site_url=http://$domain$path --no-seo
        else
            sh migrate-single.sh --site_url=http://$domain$path --no-seo --school
        fi
    fi

    iterate_num=$((iterate_num+1))
done

echo "Clearing caches…"

service apache2 restart
service varnish restart
service memcached restart
service redis-server restart

echo
echo "\033[32m\033[1mMultisite migration done! Woho!\033[0m "
