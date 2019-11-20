#!/bin/sh
# https://github.com/docker-library/httpd/blob/master/2.4/httpd-foreground

# Apache gets grumpy about PID files pre-existing
rm -f /run/apache2/apache2.pid

exec /usr/sbin/apache2ctl -DFOREGROUND
