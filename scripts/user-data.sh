#!/usr/bin/env bash
set -euo pipefail

dnf update -y
dnf install -y httpd php php-mysqlnd

install -d -m 0755 /var/www/html
printf 'healthy\n' > /var/www/html/health.html

systemctl enable httpd
systemctl restart httpd

