#! /bin/bash

DATETIME=$(date +%Y%m%d)

git pull
gitbook install
gitbook build
echo ${DATETIME}: build success >>build.log
