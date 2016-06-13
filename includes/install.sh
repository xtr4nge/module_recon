#!/bin/bash

echo "installing mitmproxy..."

apt-get -y install python-pip php5-sqlite

apt-get -y install build-essential python-dev libffi-dev libssl-dev libxml2-dev libxslt1-dev

pip install --upgrade six
pip install --upgrade pyOpenSSL

#https://pypi.python.org/packages/source/u/urwid/urwid-1.3.0.tar.gz # if error, install urwid manually first. (http://urwid.org/)

pip install mitmproxy

chmod 777 ../www.recon/db/

echo "..DONE.."
exit
