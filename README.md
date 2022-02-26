# Laravel Tracker

Laravel Tracker package provides an interface to track various
activities in Laravel projects.

- It tracks events on models you want,
- It also provides some methods to you if you want to track some activities
  manually,
- It shows all the tracked activities data and statistics on a beautiful
  dashboard

# Table Of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [How To Track Activities](#how-to-track-activities)
  - [Tracking Model Events Automatically](#tracking-model-events-automatically)
  - [Tracking Activities Manually](#tracking-activities-manually)
- [Showing Activities & Activity Statistics With Dashboard](#showing-activities---activity-statistics-with-dashboard)
- [Clearing Old Data](#clearing-old-data)

# Installation

```bash
# Install package
$ composer require emincan/laravel-tracker

# Run installer
php artisan tracker:install

# Run migrations
php artisan migrate
```

# Configuration

After the installation, the configuration file will be located at
`config/tracker.php`.

Default configuration file is like below.

```php
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
```

# How To Track Activities

There are two main approaches to using Laravel Tracker. You can use only one of
them or mix both of them.

## Tracking Model Events Automatically

This usage style provides to track model activities by listening model events
([Eloquent Events](https://laravel.com/docs/9.x/eloquent#events)).

To begin to track a model; adding the `Trackable` trait to the model is enough.

```php
use Emincan\Tracker\Trackable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable;
}
```

By default, it tracks `created`, `updated`, `deleted` events.

To update this list of events that will be listened, create a `$trackEvents`
property like below:

```php
use Emincan\Tracker\Trackable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable;
    protected static $trackEvents = ["created"];
}
```

Laravel Tracker provides support for all of the Laravel Eloquent model events.

For some special events (like `updated`), it also stores what changed on the
model.

## Tracking Activities Manually

This usage style looks like logging but it offers more.

Let's assume your users can publish new posts on your system. To track these
activities manually, the following example can be used.

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

Laravel Tracker adds request-id and IP address automatically before saving the request.

# Showing Activities & Activity Statistics With Dashboard

The dashboard url is configurable, configuration file is located at `config/trackable.php`.

By default the url is `yourdomain.com/tracker`.

# Clearing Old Data

Clearing old data is important to create more space on the database by removing
unnecessary records, preventing performance problems, etc.

Laravel Tracker has a `clear` command for this.

As basic usage, `php artisan tracker:clear` command removes activity records older than 7 days.

The command supports these additional parameters;

- `--older-than-days`: Use to specify the creation date of data to be removed.
  The default value is 7 days.
- `--chunk`: Use to specify chunk size. If you have a lot of old data to
  remove, trying to delete all of them with a single database request can be
  cause some lock / performance issues. To solve this problem, the command is
  supports chunk option. If you have 10.000 records and chunk is set to 1.000,
  the data is removed by 10 database requests - every request removes 1.000
  records. The default value is 5000.
- `--no-question`: By default, the clear command asks some questions to be sure
  you want to delete data. With the `no-question` flag, the process is complete
  without asking questions.
