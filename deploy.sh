#!/bin/bash
cp /home/rentling/env/.env /home/rentling/webroot-new/
cd /home/rentling/webroot-new/ && composer install
cd /home/rentling/webroot-new/ && npm install
cd /home/rentling/webroot-new/ && bower install --allow-root
cd /home/rentling/webroot-new/ && gulp
cp /home/rentling/env/1stHome_Rentling_Data_Migrate.sql /home/rentling/webroot-new/database/migrations/scripts
cd /home/rentling/webroot-new/ && php artisan migrate --force -vvv
#cd /home/rentling/webroot-new/ && php artisan db:seed
cp -r /home/rentling/webroot-new/* /home/rentling/webroot/
cp /home/rentling/env/.env /home/rentling/webroot/
chmod -R 777 /home/rentling/webroot/storage/
rm -rf /home/rentling/webroot-new