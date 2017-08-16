#!/bin/sh

#install apache 2.2
sudo yum -y install httpd mod_ssl

#install mysql 5.7
sudo yum -y localinstall https://dev.mysql.com/get/mysql57-community-release-el6-9.noarch.rpm
sudo yum -y install mysql-community-server

#install php 5.6 and PHP libraries
sudo rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm
sudo rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
sudo yum -y install php56w php56w-opcache
sudo yum -y install php56w-fpm
sudo yum -y install php56w-intl
sudo yum -y install php56w-gd
sudo yum -y install php56w-mbstring
sudo yum -y install php56w-mcrypt
sudo yum -y install php56w-mysqlnd
sudo yum -y install php56w-pdo
sudo yum -y install php56w-xml

sudo sed -i '304s/AllowOverride None/AllowOverride All/' /etc/httpd/conf/httpd.conf
sudo sed -i '338s/AllowOverride None/AllowOverride All/' /etc/httpd/conf/httpd.conf

#start apache
sudo chkconfig --level 3 httpd on

#start mysql
sudo chkconfig --level 3 mysqld on


