#!/bin/bash

echo "installing mitmproxy..."

apt-get -f install python-pip

apt-get -f install build-essential python-dev libffi-dev libssl-dev libxml2-dev libxslt1-dev

pip install --upgrade six

pip install mitmproxy

echo "..DONE.."
exit
