# Laravel Tracker

The Laravel Tracker package provides an interface to track various activities in Laravel projects. It can be easily use to track activities of one or multiple models or use via methods that provided by itself, comes with a basic dashboard to show tracked activity records and general statistics.

# Table Of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [How To Track Activities](#how-to-track-activities)
  * [Tracking Model Activities Automatically](#tracking-model-activities-automatically)
  * [Tracking Activities Manually](#tracking-activities-manually)
- [Showing Activities & Activity Statistics With Dashboard](#showing-activities---activity-statistics-with-dashboard)
- [Clearing Old Data](#clearing-old-data)
 
# Installation

After following steps below, you will be ready to use Laravel Tracker. Database migration, assets for the dashboard and tracker configuration file will be published. 

* Install package with composer: `composer require emincan/laravel-tracker`
* Run installer: `php artisan tracker:install`
* Migrate database: `php artisan migrate` 

# Configuration

After the following installation steps, the configuration can be found in `config/tracker.php`. There are not much configuration options, so a quick look before start to use it is may be good.

`dashboard=>middlewares` can be used to set middlewares for the dashboard. **Auth middlewares highly recommended for production usage**.

`dashboard=>prefix` can be used to set dashboard url. For example, If you want to access dashboard by yourdomain.com/admin-tracker, then set prefix to "admin-tracker".

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

Basically, there are 2 main approaches to using Laravel Tracker. You can use only one of them or mix both of them.

## Tracking Model Activities Automatically

This usage style provides to track model activities by listening model events. Default listening events are `"created", "updated", "deleted"` but the list is easily configurable.

To begin tracks a model; adding `Trackable` trait to model is enough.

```php
use Emincan\Tracker\Trackable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable;
}
```

If you want to change listening events, override `$trackEvents` variable like below;

```php
use Emincan\Tracker\Trackable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Trackable;
    protected static $trackEvents = ["created"];
}
```

All of the Laravel model events are supported; but if some supported events caught (like `updated`), then laravel-tracker is also saves what changes on it as additional data. 

 
## Tracking Activities Manually

This usage style is looking like logging but it offers more.   

Let's assume your users can publish new posts on your system. To tracking these activities manually, this example can be use.

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
There is no required parameter, but at least adding trackable and action is highly recommended.

Laravel Tracker adds request id and ip address automatically before it saves the request.

# Showing Activities & Activity Statistics With Dashboard

With default configuration, the dashboard url is `yourdomain.com/tracker` 
If you have changed dashboard prefix on `config/trackable.php`, then use `yourdomain.com/prefix-you-wrote`.

**It is important to add auth middleware to dashboard on production for security reasons.**

# Clearing Old Data

Clearing old data is important to create more space on database by removing unnecessary records, to prevent performance problems etc. 

Laravel Tracker has `clear` command for this.

As basic usage, `php artisan tracker:clear` command is removes activity records older than 7 days.

The command supports these additional parameters;

* `--older-than-days`: Use to specify the creation date of data to be removed. The default value is 7 days. 
* `--chunk`: Use to specify chunk size. If you have a lot of old data to remove, trying to delete all of them with single database request can be cause some lock / performance issues. To solve this problem, the command is supports chunk option. If you have 10.000 records and chunk is set to 1.000, the data is removed by 10 database requests - every request removes 1.000 records. The default value is 5000.
* `--no-question`: Without this parameter, Tracker Clear command asks some questions to be sure you want to delete data. This situation can cause some problems when you want to use it with cronjobs etc, because of there are no people to answer questions of command. With no-question flag, process is complete without asking questions.

