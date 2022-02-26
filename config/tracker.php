<?php

return [

  /** Tracker Dashboard Settings */

  "dashboard" => [

    /**
     *  When trying to access tracker dashboard, these middlewares will be used.
     *  You can add your own middlewares or built in Laravel middlewares here.
     *  For production usage, it is recommended to add "auth" or another middleware
     *  that provides authorization.
     */
    "middlewares" => ['web'],

    /**
     *  This prefix is using as `route prefix`.
     *  Basically if you set it as "laravel-tracker",
     *  then dashboard endpoint is become yourdomain.com/laravel-tracker.
     *  If you don't change initial value which is set to "tracker",
     *  your default endpoint is yourdomain.com/tracker
     */
    'prefix' => 'tracker'
  ],
];
