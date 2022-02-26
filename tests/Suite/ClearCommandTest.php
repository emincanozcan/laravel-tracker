<?php

namespace Emincan\Tracker\Tests\Suite;

use Emincan\Tracker\Models\TrackerActivity;
use Emincan\Tracker\Tests\Models\User;
use Emincan\Tracker\Tests\TestCase;
use Emincan\Tracker\Tracker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class ClearCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testClearCommandExpectsConfirmation()
    {
        $this->createUser();
        $this->assertCount(1, TrackerActivity::all());
        $this->artisan('tracker:clear')
      ->expectsConfirmation('Records created before 7 days will be deleted. Do you wish to continue?', 'no')
      ->assertExitCode(1);
    }

    /** @test */
    public function testClearCommandRunIfConfirmed()
    {
        $this->createUser();
        $this->assertCount(1, TrackerActivity::all());
        TrackerActivity::first()->update(['created_at' => now()->subDays(8)->toDateTimeString()]);
        $this->artisan('tracker:clear')
      ->expectsConfirmation('Records created before 7 days will be deleted. Do you wish to continue?', 'yes')
      ->expectsOutput("Records are deleted successfully.")
      ->assertExitCode(0);
        $this->assertCount(0, TrackerActivity::all());
    }

    /** @test */
    public function testClearDoesNotExpectConfirmationIfNoQuestionFlagIsAdded()
    {
        $this->createUser();
        $this->assertCount(1, TrackerActivity::all());
        TrackerActivity::first()->update(['created_at' => now()->subDays(8)->toDateTimeString()]);
        $this->artisan('tracker:clear --no-question')->assertExitCode(0);
        $this->assertCount(0, TrackerActivity::all());
    }

    /** @test */
    public function testClearCommandRespectsOlderThanDaysParameter()
    {
        $user = $this->createUser();
        $user->posts()->create(['title' => 'test-post']);

        $data = TrackerActivity::all();
        $data[0]->created_at = now()->subDays(5)->toDateTimeString();
        $data[1]->created_at = now()->subDays(3)->toDateTimeString();
        $data[0]->save();
        $data[1]->save();

        $this->assertCount(2, TrackerActivity::all());
        $this->artisan('tracker:clear --older-than-days=4 --no-question')->assertExitCode(0);
        $this->assertCount(1, TrackerActivity::all());
        $this->assertEquals($data[1]->trackable_type, TrackerActivity::first()->trackable_type);
        $this->assertEquals($data[1]->trackable_id, TrackerActivity::first()->trackable_id);
    }

    /** @test */
    public function testClearCOmmandRespectsChunkParameter()
    {
        $user = $this->createUser();
        for ($i = 0; $i < 99; $i++) {
            $user->posts()->create(['title' => 'test-post']);
        }
        $totalCount = TrackerActivity::count();
        $this->artisan('tracker:clear --older-than-days=0 --no-question --chunk=10')
      ->expectsOutput("Deleting process is starting. Please wait until to see the success message.")
      ->expectsOutput("Status: 10 / {$totalCount} deleted.")
      ->expectsOutput("Status: 30 / {$totalCount} deleted.")
      ->expectsOutput("Status: 60 / {$totalCount} deleted.")
      ->expectsOutput("Records are deleted successfully.")
      ->assertExitCode(0);
    }

    private function createUser()
    {
        return User::create(['name' => "Emincan", "email" => "emincanozcann@gmail.com", "password" => 'hashed_password']);
    }
}
