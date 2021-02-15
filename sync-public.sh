#!/bin/bash

# This shell script is actually dev-only and only purpose of it making easier to develop assets
# by copy them automatically to Laravel's public directory. Normally this is happen when
# user run `php artisan vendor:publish --tag=tracker-assets` command in cli.

watch -n 2 cp public/js/app.js ../../../public/vendor/emincan/tracker/js/app.js &
watch -n 2 cp public/css/app.css ../../../public/vendor/emincan/tracker/css/app.css &
wait
