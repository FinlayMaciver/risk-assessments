#!/bin/bash
echo "TLS_REQCERT never" >> /etc/openldap/ldap.conf
curl -s -o mongo.tgz https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-2.2.7.tgz
tar -xzf mongo.tgz
mv mongodb-linux-x86_64-2.2.7 /opt/mongodb
rm -f mongo.tgz
yum -y install http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm 
yum -y install httpd php php-ldap php-mcrypt php-cli php-pear php-pdo php-pear-Mail-mime php-devel php-mcrypt rsync mcrypt vim php-xml gcc kernel-devel-2.6.32-431
yes no | sudo pecl install mongo
echo "extension=mongo.so" > /etc/php.d/mongodb.ini
sed -i -e 's/AllowOverride None/AllowOverride All/g' /etc/httpd/conf/httpd.conf
sed -i -e 's/index.html.var/index.html.var index.php/g' /etc/httpd/conf/httpd.conf

chkconfig httpd on
service httpd start
sudo mkdir -p /data/db
sudo /opt/mongodb/bin/mongod --fork --syslog

cat > /home/vagrant/sync.sh <<EOS
#!/bin/bash
sudo rsync -av /vagrant/* /var/www/html/risk
cd /var/www/html/risk
sudo chown -R apache /var/www/html/risk/templates_c
sudo chown -R apache /var/www/html/risk/cache
EOS
chmod +x /home/vagrant/sync.sh
/home/vagrant/sync.sh

