<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /** @test */
    public function user_can_create_a_project()
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);
        $this->withoutExceptionHandling();
        $attr = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/projects', $attr);
        $this->assertDatabaseHas('projects', $attr);

        $this->get('/projects')->assertSee($attr['title']);
    }

    /** @test */
    public function require_title()
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);

        $attr = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $attr)->assertSessionHasErrors('title');
    }
    /** @test */
    public function require_description()
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);

        $attr = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attr)->assertSessionHasErrors('description');
    }



    /** @test */
    public function project_requires_an_owner()
    {
        $attr = Project::factory()->raw();
        $this->post('/projects', $attr)->assertRedirect('login');
    }


    /** @test */
    public function guest_can_not_view_projects()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    /** @test */
    public function user_can_view_their_projects()
    {
        $this->be(User::factory()->create()->first());
        $this->withoutExceptionHandling();
        $project =  Project::factory()->create(['user_id' => auth()->id()]);
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function user_can_create_project()
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);
        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['title']);
    }
}
