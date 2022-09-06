# PHP

App for delegating projects-task managment with phpunit and TDD approach

## 1. 1st test

create test with artisan 

1.1  populate file with fake post query

1.2 make sure that DB_DATABASE is set for memory

1.3 create migration - for db  + model with mass assignment turned off

1.4 create model + mass assignment turn off 

1.5 create route - use static method ::create and fetch request data 

1.6 update test to display title on page  + update route + create blade 

1.7 create controller and refactor routes - methods 



## 2. Testing request validation

​	2.1. create new test methods 

```php
    public function require_title()
    {
        $attr = Project::factory()->raw(['title' => '']);
```



​	2.2 create factory - run it in tinker 

​	2.3 update store method inside Controller 

```php
$args = request()->validate(['title' => 'required', 'description' => 'required']);
```





## 3. Test to see single post - model test

​	3.1. Create test - user can view project + route + controller method (route model mining) 

​	3.2 create unit test for model -  that path() method works on model 

unit test for model

```bash
php artisan make:test ProjectTest --unit
```

