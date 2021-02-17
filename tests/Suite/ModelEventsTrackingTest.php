<?php

namespace Emincan\Tracker\Tests\Suite;

use Emincan\Tracker\Models\TrackerActivity;
use Emincan\Tracker\Tests\Models\Post;
use Emincan\Tracker\Tests\Models\User;
use Emincan\Tracker\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelEventsTrackingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function createdEventIsTracked()
    {
        $user = $this->createUser();
        $this->assertCount(1, TrackerActivity::all());
        $activity = TrackerActivity::first();
        $this->assertEquals($activity->trackable_id, $user->id);
        $this->assertEquals($activity->trackable_type, User::class);
        $this->assertEquals($activity->action, 'created');
        $this->assertEquals($activity->message, class_basename(User::class) . " is created");
    }
    /** @test */
    public function deletedEventIsTracked()
    {
        $user = $this->createUser();
        $user->delete();

        $this->assertCount(2, TrackerActivity::all());

        $activity = TrackerActivity::orderByDesc('id')->first();
        $this->assertEquals($activity->trackable_id, $user->id);
        $this->assertEquals($activity->trackable_type, User::class);
        $this->assertEquals($activity->action, 'deleted');
        $this->assertEquals($activity->message, class_basename(User::class) . " is deleted");
    }

    /** @test */
    public function updatedEventIsTracked()
    {
        $user = $this->createUser();
        $user->name = "Ozcan";
        $user->save();

        $this->assertCount(2, TrackerActivity::all());

        $activity = TrackerActivity::orderByDesc('id')->first();
        $this->assertEquals($activity->trackable_id, $user->id);
        $this->assertEquals($activity->trackable_type, User::class);
        $this->assertEquals($activity->action, 'updated');
        $this->assertEquals($activity->message, class_basename(User::class) . " is updated");

        $additionalData = $activity->additional_data;

        $this->assertEquals($additionalData['original']['name'], 'Emincan');
        $this->assertEquals($additionalData['changes']['name'], 'Ozcan');
    }

    /** @test */
    public function allTrackedEventsAreStored()
    {
        $user = $this->createUser();
        $user->name = "Ozcan";
        $user->save();
        $user->delete();

        $all = TrackerActivity::orderBy('id')->get();
        $this->assertCount(3, $all);
        $this->assertEquals($all[0]->action, 'created');
        $this->assertEquals($all[1]->action, 'updated');
        $this->assertEquals($all[2]->action, 'deleted');
    }

    /** @test */
    public function eventsAreTrackedWhenTriggeredWithRelations()
    {
        // Only created event is tracked on Post.
        $user = $this->createUser();
        $post = $user->posts()->create(['title' => "Title Of Post"]);

        $activity = TrackerActivity::orderByDesc('id')->first();
        $this->assertEquals($activity->trackable_id, $post->id);
        $this->assertEquals($activity->trackable_type, Post::class);
        $this->assertEquals($activity->action, 'created');
        $this->assertEquals($activity->message, class_basename(Post::class) . " is created");

        $count = TrackerActivity::count();

        $user->posts()->where(['title' => "Title Of Post"])->update(['title' => "Test Title"]);
        $activity = TrackerActivity::orderByDesc('id')->first();
        $this->assertNotEquals($activity->action, 'updated');
        $this->assertCount($count, TrackerActivity::all());

        $user->posts()->where(['title' => "Title Of Post"])->delete();
        $activity = TrackerActivity::orderByDesc('id')->first();
        $this->assertNotEquals($activity->action, 'deleted');
        $this->assertCount($count, TrackerActivity::all());
    }

    private function createUser()
    {
        return User::create(['name' => "Emincan", "email" => "emincanozcann@gmail.com", "password" => 'hashed_password']);
    }
}
