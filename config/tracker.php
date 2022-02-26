<?php

return [

    /** Tracker Dashboard Settings */

    "dashboard" => [
        /**
         * When trying to access the Laravel Tracker dashboard, these middlewares will be used.
         * You can add your own middlewares or built-in Laravel middlewares here.
         * For production usage, it is recommended to add "auth" or another middleware that provides authorization.
         */
        "middlewares" => ['web'],

        /**
         *  This prefix using as `route prefix`.
         *  By default, the dashboard is available at: yourdomain.com/tracker
         *  If you want to access the dashboard by yourdomain.com/my-dashboard, then update this value to 'my-dashboard'
         */
        'prefix' => 'tracker'
    ],
];
