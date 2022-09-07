<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function project_can_have_tasks()
    {
        $this->be(User::factory()->create()->first());

        $project = Project::factory()->create(['user_id' => auth()->id()]);
        $this->post($project->path() . '/tasks', ['body' => 'Test task']);
        $this->get($project->path())
            ->assertSee('Test task');
    }
}
