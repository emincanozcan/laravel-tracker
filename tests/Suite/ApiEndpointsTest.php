<?php

namespace Emincan\Tracker\Tests\Suite;

use Emincan\Tracker\Models\TrackerActivity;
use Emincan\Tracker\Tests\Models\Post;
use Emincan\Tracker\Tests\Models\User;
use Emincan\Tracker\Tests\TestCase;
use Emincan\Tracker\Tracker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiEndpointsTest extends TestCase
{
  use RefreshDatabase;
  private $user;
  private $post;
  private $post2;
  private $tag;

  /** @test */
  public function lastActivitiesCanBeFetchedWithoutFilters()
  {
    $this->initBasic();
    $response = $this->get(route("tracker.last-activities"));
    $response->assertStatus(200)->assertJson([
      "data" => [
        ["trackable_type" => get_class($this->user), "trackable_id" => $this->user->id],
        ["trackable_type" => get_class($this->post), "trackable_id" => $this->post->id],
        ["trackable_type" => get_class($this->post2), "trackable_id" => $this->post2->id]
      ]
    ]);
    $this->assertCount(3, $response['data']);
  }

  /** @test */
  public function lastActivitiesCanBeFetchedWithTrackableFilter()
  {
    $this->initBasic();
    $response = $this->get(route("tracker.last-activities", [
      'trackable_type' => get_class($this->user),
      'trackable_id' => $this->user->id
    ]));
    $response->assertStatus(200)->assertJson([
      "data" => [
        ["trackable_type" => get_class($this->user), "trackable_id" => $this->user->id],
      ]
    ]);
    $this->assertCount(1, $response['data']);
  }

  /** @test */
  public function lastActivitiesCanBeFetchedWithIpAddressFilter()
  {
    $this->initBasic();
    $firstRecord = TrackerActivity::first();
    $ipAddress = $firstRecord->ip_address;

    $firstRecord->ip_address = "999.999.999.999";
    $firstRecord->save();

    $response = $this->get(route("tracker.last-activities", ['ip_address' => $ipAddress]));
    $response->assertStatus(200)->assertJson([
      "data" => [
        ["ip_address" => $ipAddress],
        ["ip_address" => $ipAddress],
      ]
    ]);
    $this->assertCount(2, $response['data']);
  }

  /** @test */
  public function lastActivitiesCanBeFetchedWithActionFilter()
  {
    $this->initBasic();
    $this->post->title = "another title";
    $this->post->save();
    $this->assertCount(4, TrackerActivity::all());

    $response = $this->get(route("tracker.last-activities", ['action' => "created"]));
    $response->assertStatus(200)->assertJson([
      "data" => [
        ["action" => "created"],
        ["action" => "created"],
        ["action" => "created"],
      ]
    ]);
    $this->assertCount(3, $response['data']);

    $response = $this->get(route("tracker.last-activities", ['action' => "updated"]));
    $response->assertStatus(200)->assertJson([
      "data" => [
        ["action" => "updated"],
      ]
    ]);
    $this->assertCount(1, $response['data']);

    $this->post->delete();
    $response = $this->get(route("tracker.last-activities", ['action' => "deleted"]));
    $response->assertStatus(200)->assertJson([
      "data" => [
        ["action" => "deleted"],
      ]
    ]);
    $this->assertCount(1, $response['data']);
  }


  /** @test */
  public function lastActivitiesCanBeFetched()
  {
    $this->initBasic();
    $firstRecord = TrackerActivity::first();
    $firstRecord->request_id = "custom-request-id";
    $firstRecord->save();

    $response = $this->get(route("tracker.last-activities", ['request_id' => "custom-request-id"]));
    $response->assertStatus(200)->assertJson([
      "data" => [
        ["request_id" => "custom-request-id"],
      ]
    ]);
    $this->assertCount(1, $response['data']);
  }

  /** @test */
  public function activityStatisticsCanBeFetched()
  {
    $this->initBasic();

    for ($i = 0; $i < 10; $i++) {
      $this->user->saveActivity("user-action{$i}", 'test-message');
      $this->post->saveActivity("post-action{$i}", 'test-message');
    }

    $expectedCountByAction = [['action' => "created", "action_count" => 3]];
    for ($i = 0; $i < 10; $i++) {
      $expectedCountByAction[] = [
        "action_count" => 1,
        "action" => "user-action{$i}"
      ];
      $expectedCountByAction[] = [
        "action_count" => 1,
        "action" => "post-action{$i}"
      ];
    }
    $totalCount = TrackerActivity::count();

    $expectedTrackableTypeCount = [
      [
        "trackable_type_count" =>  TrackerActivity::where('trackable_type', get_class($this->post))->count(),
        "trackable_type" =>  get_class($this->post)
      ],
      [
        "trackable_type_count" =>  TrackerActivity::where('trackable_type', get_class($this->user))->count(),
        "trackable_type" =>  get_class($this->user)
      ]
    ];

    $response = $this->get(route("tracker.activity-statistics"));
    $response->assertStatus(200)->assertJsonFragment([
      "total_count" => $totalCount,
      "count_by_trackable_types" => $expectedTrackableTypeCount,
      "count_by_action" => $expectedCountByAction
    ]);
  }

  /** @test */
  public function differentActionsAndTrackableTypesCanBeFetchedToFilterResults()
  {
    $this->initBasic();
    $this->post2->delete();
    $this->get(route('tracker.filters'))->assertJsonFragment([
      "action" => ["created", "deleted"],
      "types" => [
        get_class($this->user),
        get_class($this->post)
      ]
    ]);
  }

  private function initBasic()
  {
    $this->user = $this->createUser();
    $this->post = $this->user->posts()->create(['title' => "post 1"]);
    $this->post2 = $this->user->posts()->create(['title' => "post 2"]);
    $this->tag = $this->post->tags()->create(['title' => "tag 1"]);
  }
  private function createUser()
  {
    return User::create(['name' => "Emincan", "email" => "emincanozcann@gmail.com", "password" => 'hashed_password']);
  }
}
