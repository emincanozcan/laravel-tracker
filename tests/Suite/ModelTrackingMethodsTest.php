<?php

namespace Emincan\Tracker\Tests\Suite;

use Emincan\Tracker\Models\TrackerActivity;
use Emincan\Tracker\Tests\Models\User;
use Emincan\Tracker\Tests\TestCase;
use Emincan\Tracker\Tracker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelTrackingModelsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function trackableModelsHasSaveActivityMethod()
    {
        $user = $this->createUser();
        $this->assertTrue(method_exists($user, 'saveActivity'));

        $post = $user->posts()->create(['title' => "test title"]);
        $this->assertTrue(method_exists($post, 'saveActivity'));
    }

    /** @test */
    public function trackableModelsHasGetActivitiesMethod()
    {
        $user = $this->createUser();
        $this->assertTrue(method_exists($user, 'getActivities'));

        $post = $user->posts()->create(['title' => "test title"]);
        $this->assertTrue(method_exists($post, 'getActivities'));
    }


    /** @test */
    public function notTrackableModelsHasNotSaveActivityMethod()
    {
        $user = $this->createUser();
        $post = $user->posts()->create(['title' => "test title"]);
        $tag = $post->tags()->create(['title' => "test tag"]);
        $this->assertFalse(method_exists($tag, 'saveActivity'));
    }

    /** @test */
    public function newActivityCanStoreWithSaveActivityMethod()
    {
        $user = $this->createUser();
        $user->saveActivity('test-action', 'test-message', ['test' => "123", "123" => "test"]);

        $this->assertCount(2, TrackerActivity::all());
        $activity = TrackerActivity::orderByDesc('id')->first();

        $this->assertEquals($activity->trackable_id, $user->id);
        $this->assertEquals($activity->trackable_type, User::class);
        $this->assertEquals('test-action', $activity->action);
        $this->assertEquals('test-message', $activity->message);
        $this->assertIsArray($activity->additional_data);
        $this->assertEquals("123", $activity->additional_data['test']);
        $this->assertEquals("test", $activity->additional_data['123']);
    }

    /** @test */
    public function activitiesCanGetWithGetActivitiesMethod()
    {
        $user = $this->createUser();
        $user->saveActivity('test-action', 'test-message', ['test' => "123", "123" => "test"]);

        $this->assertCount(2, $user->getActivities());
        $post = $user->posts()->create(['title' => 'post-title']);
        $this->assertCount(2, $user->getActivities());
        $this->assertCount(1, $post->getActivities());
    }

    private function createUser()
    {
        return User::create(['name' => "Emincan", "email" => "emincanozcann@gmail.com", "password" => 'hashed_password']);
    }
}
