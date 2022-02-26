# Laravel Tracker

The Laravel Tracker package provides an interface to track various
activities within Laravel projects.

- It tracks events on models you want,
- It also provides some methods to you if you want to track some activities
  manually,
- It shows all the tracked activities data and statistics on a beautiful
  dashboard

## Table Of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [How To Track Activities](#how-to-track-activities)
  - [Tracking Model Events Automatically](#tracking-model-events-automatically)
  - [Tracking Activities Manually](#tracking-activities-manually)
- [Dashboard](#dashboard)
- [Clearing Old Data](#clearing-old-data)

## Installation

```bash
# Install package
$ composer require emincan/laravel-tracker

# Run installer
$ php artisan tracker:install

# Run migrations
$ php artisan migrate
```

## Configuration

After the installation, the configuration file will be located at
`config/tracker.php`.

Default configuration file is like below.

```php
<?php
return [
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
```

## How To Track Activities

Laravel Tracker offers two main approaches that can be used separately or combined.

### Tracking Model Events Automatically

This usage style allows for tracking model activities by listening to model events.
([Eloquent Events](https://laravel.com/docs/9.x/eloquent#events)).

To start tracking a model, all you need to do is add the Trackable trait to the model.

```php
use Emincan\Tracker\Trackable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable;
}
```

By default, it tracks `created`, `updated`, `deleted` events.

To customize the list of events that Laravel Tracker will listen to,
you can create a `$trackEvents` property in the model:

```php
use Emincan\Tracker\Trackable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable;
    protected static $trackEvents = ["created"];
}
```

Laravel Tracker supports all of the Laravel Eloquent model events.

For some special events (like `updated`), it also stores what changed on the
model.

### Tracking Activities Manually

This usage style may resemble logging, but it offers more functionality.

For instance, let's assume that users can publish new posts on your system.
You can manually track these activities by using the following example:

```php
// your code...
// $user->publish($post);
(new Tracker)
  ->setTrackable(\App\Model\Post::class, $post->id)
  ->setAction("user_published_a_post")
  ->setMessage("Post is published by user.")
  ->setAdditionalData([
    "user_email" => $user->email,
    "post_has_media" => true
  ])
  ->save();
```

Laravel Tracker automatically adds the request ID and IP address before saving the request.

## Dashboard

By default, the dashboard url is `yourdomain.com/tracker`.

The url is configurable, configuration file is located at `config/trackable.php`.

## Clearing Old Data

Clearing old data is an essential task to create more space in the database by
removing unnecessary records, preventing performance problems, and ensuring
smooth operations.

Laravel Tracker has a `clear` command for this.

The basic usage of the `php artisan tracker:clear` command is to remove activity
records that are older than 7 days.

The command supports these additional parameters;

- `--older-than-days`: The --older-than-days parameter is used to specify the
  minimum age of data to be removed. By default, data older than 7 days will be
  removed.
- `--chunk`: The --chunk option allows you to specify the size of the chunks
  that will be deleted at a time. This is useful when there is a large amount of
  data to be deleted, as trying to delete all of them with a single database request
  can cause lock and performance issues. For example, if you have 10,000 records
  and set the chunk size to 1,000, the data will be removed in 10 database
  requests, with each request removing 1,000 records. The default value
  for --chunk is 5,000.
- `--no-question`: By default, the clear command of Laravel Tracker prompts
  the user with questions to confirm whether they want to delete data.
  However, if you use the no-question flag with the command, the process will
  complete without asking any questions.
