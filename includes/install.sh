#!/bin/bash

echo "installing mitmproxy..."

apt-get -y install python-pip

apt-get -y install build-essential python-dev libffi-dev libssl-dev libxml2-dev libxslt1-dev

pip install --upgrade six

pip install mitmproxy

echo "..DONE.."
exit
