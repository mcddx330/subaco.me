#!/bin/bash

#find storage/framework/cache/* -type d|xargs rm -rf
rm -rf storage/framework/views/*.php
php artisan serve --host="dev-subaco.me" --port="8080"
