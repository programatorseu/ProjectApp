# PHP

App for delegating projects-task managment with phpunit and TDD approach

## 1. 1st test

create test with artisan

1.1 populate file with fake post query

1.2 make sure that DB_DATABASE is set for memory

1.3 create migration - for db + model with mass assignment turned off

1.4 create model + mass assignment turn off

1.5 create route - use static method ::create and fetch request data

1.6 update test to display title on page + update route + create blade

1.7 create controller and refactor routes - methods

## 2. Testing request validation

 2.1. create new test methods

```php
    public function require_title()
    {
        $attr = Project::factory()->raw(['title' => '']);
```

 2.2 create factory - run it in tinker

 2.3 update store method inside Controller

```php
$args = request()->validate(['title' => 'required', 'description' => 'required']);
```

## 3. Test to see single post - model test

 3.1. Create test - user can view project + route + controller method (route model mining)

 3.2 create unit test for model - that path() method works on model

unit test for model

```bash
php artisan make:test ProjectTest --unit
```

## 4 Project require owner

 4.1 create test - project requires_an_owner + update migration + migrate refresh

 4.2 update factory to have id + store method required param

 4.3 add vue auth / add middleware to route - redirection / update tests

 4.4 unit test for user-project relationship | add method to model | update store in controller

```php
   Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
```

```bash
composer require laravel/ui:^3.4
php artisan ui bootstrap --auth
```

first test - use @raw to get array not collection

```php
    public function project_requires_an_owner()
    {
        $attr = Project::factory()->raw();
        $this->post('/projects', $attr)->assertRedirect('login');
```

```php
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
```

@store:

```php
    public function store()
    {
        $attr = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $attr['user_id'] = auth()->id();
        Project::create($attr);
        return redirect('/');
    }
```

## 5. Connect Project - to user

1. group middleware to grab all Project's routes:
2. create method inside @show method
3. add relation to Project model - owner by user
4. ProjectsController@index -> show only projects created by authenticated user
5. create middleweare + tinker run
6. lock ability to see other projects
7. route group - middleware
8. ProjectsController@show - condition to check

## 6. Create project -view

## 7. Project Task relation

utility method for testing :

```php
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        return $this->actingAs($user ?: User::factory()->create());
    }

}
```

## 8. Task - touch it

when we add task / update --- project (date) should be updated

we want to **touch** parent relationship - touch it any relationship

```php
class Task extends Model
{
    protected $guarded = [];
    protected $touches = ['project'];

```

## 9. Notes + policy

-> migration in order to pass notes 

-> update @store method 

-> create @update method to pass only notes

-> create Policy 

**interesting case:  **

```php
        $project->update([
            'notes' => request('notes')
        ])
```

```
 #attributes: array:7 [▼
    "id" => 1

    "notes" => "any notes that goes here"
    "created_at" => "2022-09-09 12:08:45"
    "updated_at" => "2022-09-09 12:08:55"
  ]
```



```php
        $project->update(request(['notes']));
```

```
  "description" => "learn this shit"
    "notes" => array:1 [▼
      "notes" => "any notes that goes here"
    ]
```

## 10. Reduce Form + validation

1. change @update method
2. add `edit` endpoint 



**FORM REQUEST !! **

we have used protected method inside controller but now we would like to change to ```FormRequest``` : 

 sometimes when validation is more significant - better is to extract form requdst :

> keep validation / creation all together 

```bash
php artisan make:request UpdateProjectRequest 
```

stored inside app/http/Requests

there 2 methods

- authorize  - whether we can do or not that request 

  >  we will move our authorization here (but we need to use Gate because authorize is a trait on our  controller )

  we need access for project -> use route model binding 

- vlidation rules 

we want this gate : `use Illuminate\Support\Facades\Gate;`

then usage :

```php
    public function update(UpdateProjectRequest $request, Project $project,)
    {
        $project->update($request->validated());
        return redirect($project->path());
    }
```

## 11. Activity 

1. create model + migration (connect with project )

2. create observer - register inside `AppServiceProvider`

   

---

On ProjectObserver

```php
class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $project->recordActivity('created');
    }

    public function updated(Project $project)
    {
        $project->recordActivity('updated');
    }
```

we call `recordActivity` on Project eloquent model

Project@recordActivity

- method responsible for creating Activity

```php
    public function recordActivity($type)
    {
        Activity::create([
            'project_id' => $this->id,
            'description' => $type
        ]);
    }
```

i task we have 2 expectaions - when is created & completed: 

```php
    protected static function boot()
    {
        parent::boot();
        static::created(function ($task) {
            $task->project->recordActivity('created_task');
        });
    }
    public function complete()
    {
        $this->update(['completed' => true]);
        $this->project->recordActivity('completed_task');
    }
```



--> **refactor**

in Project model we have activity relationship already set up 

* we are going to refector recordActivty method

- add Activity for **incompliting **

​	-- ProjectTaskController@update

- add TaskObserver 
