<?php

namespace Tests\Feature;

use App\Models\Project;
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
        $attr = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $attr)->assertSessionHasErrors('title');
    }
    /** @test */
    public function require_description()
    {
        $attr = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attr)->assertSessionHasErrors('description');
    }
}
