#!/bin/bash

watch -n 5 cp public/js/app.js ../../../public/vendor/emincan/tracker/js/app.js &
watch -n 5 cp public/css/app.css ../../../public/vendor/emincan/tracker/css/app.css &
wait