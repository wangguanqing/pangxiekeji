#!/bin/sh

chown -R www:www /data/www/www.pangxiekeji.com/pangxiekeji/
chmod -R 755 /data/www/www.pangxiekeji.com/pangxiekeji/
rsync -zar --no-t --no-p --chmod=u=rwX,og=rX --password-file=/etc/rsyncd.pwdpangxie /data/www/www.pangxiekeji.com/pangxiekeji/* pangxie@42.62.14.116::www/test.pangxiekeji.com --exclude=.* --exclude=caches/* --exclude=html/* --exclude=about/ --exclude=git.tar.gz --exclude=uploadfile/*  --exclude=phpsso_server/ --exclude=/index.html --exclude=*.sh --exclude=*.gz --exclude=phpcms/templates/ --exclude=phpcms/languages/zh-cn/system_menu.lang.php --exclude=receiver.php -v
