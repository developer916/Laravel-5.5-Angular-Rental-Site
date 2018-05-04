#!/bin/bash         

echo "@@@@@@@@@"
echo 'Programming is like sex. One mistake and you have to support it for the rest of your life.'
echo "@@@@@@@@@"

#### Git PULL

echo -e "\e[31mPulling data from bitbucket\e[0m"
git pull
echo -e "[git] \e[92mdone"


#### Composer Update

echo -e "\e[31mRunning composer\e[0m"
rm -f composer.lock
composer install
echo -e "[composer] \e[92mdone"

#### Bower

echo -e "\e[31mRunning bower\e[0m"
bower install --allow-root
echo -e "[bower] \e[92mdone"

#### NPM

#echo -e "\e[31mRunning NPM update\e[0m"
#npm update
#echo -e "[npm] \e[92mdone"

#### Gulp

echo -e "\e[31mRunning gulp\e[0m"
gulp
echo -e "[gulp] \e[92mdone"
