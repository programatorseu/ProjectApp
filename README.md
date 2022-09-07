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

​ 2.1. create new test methods

```php
    public function require_title()
    {
        $attr = Project::factory()->raw(['title' => '']);
```

​ 2.2 create factory - run it in tinker

​ 2.3 update store method inside Controller

```php
$args = request()->validate(['title' => 'required', 'description' => 'required']);
```

## 3. Test to see single post - model test

​ 3.1. Create test - user can view project + route + controller method (route model mining)

​ 3.2 create unit test for model - that path() method works on model

unit test for model

```bash
php artisan make:test ProjectTest --unit
```

## 4 Project require owner

​ 4.1 create test - project requires_an_owner + update migration + migrate refresh

​ 4.2 update factory to have id + store method required param

​ 4.3 add vue auth / add middleware to route - redirection / update tests

​ 4.4 unit test for user-project relationship | add method to model | update store in controller

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
