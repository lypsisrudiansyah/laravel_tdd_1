# Laravel TDD Api's Todo List App 

This is API's of Todo List App that allows users to create and manage todo lists and tasks using Laravel and Test Driven Development (TDD).

## Features

- Users can register and login with their email and password.
- Users can create, edit, delete and mark as completed their own todo lists.
- Users can add, edit, delete and mark as done their own tasks within a todo list.
- Users can view all their todo lists and tasks.

## Installation

To install this application, you need to have PHP, Composer and MySQL installed on your system. Then follow these steps:

- Clone this repository to your local machine: `git clone https://github.com/lypsisrudiansyah/laravel_tdd_1.git`
- Navigate to the project directory: `cd laravel_tdd_1`
- Install the dependencies: `composer install`
- configure the .env
- Generate an application key: `php artisan key:generate`
- Run the database migrations and seeders: `php artisan migrate --seed`
- Start the local development server: `php artisan serve`
- Running route list, to see all endpoints API : `php artisan route:list`

## Testing

### Testing Using PHP Unit
This application uses PHPUnit for testing. To run the tests, use this command:
`php artisan test`
or
`vendor/bin/phpunit`

![image](https://github.com/lypsisrudiansyah/laravel_tdd_1/assets/52348378/32d03105-17a2-4dc9-b77c-acb7eb80f057)
![vendor phpunit2](https://github.com/user-attachments/assets/83e6e39e-08a2-417b-ac55-5c18dde6164d)


### Testing on VsCode
![image](https://github.com/lypsisrudiansyah/laravel_tdd_1/assets/52348378/860195e7-5ad1-4687-b847-d426148cc847)


The tests cover the following features:

- User registration and login
- Todo list creation, editing, deletion and completion
- Task creation, editing, deletion and completion

#### Test Coverage
```
Exceptions\Handler  .......................................................... 100.0 %  
Http/Controllers/Auth\LoginController  ....................................... 100.0 %  
Http/Controllers/Auth\RegisterController  .................................... 100.0 %  
Http/Controllers\Controller  ................................................. 100.0 %  
Http/Controllers\TaskController  ............................................. 100.0 %  
Http/Controllers\TodoListController  ......................................... 100.0 %  
Http\Kernel  ................................................................. 100.0 %  
Http/Requests\LoginRequest ..................................................... 0.0 %  
Http/Requests\RegisterRequest  ............................................... 100.0 %  
Http/Requests\TaskRequest  ................................................... 100.0 %  
Http/Requests\TodoListRequest  ............................................... 100.0 %  
Models\Task  ................................................................. 100.0 %  
Models\TodoList  ............................................................. 100.0 %  
Models\User  ................................................................. 100.0 %  
Providers\AppServiceProvider  ................................................ 100.0 %  
Providers\AuthServiceProvider  ............................................... 100.0 %  
Providers\BroadcastServiceProvider ............................................. 0.0 %  
Providers\EventServiceProvider  .............................................. 100.0 %  
Providers\RouteServiceProvider  .............................................. 100.0 %  

Total Coverage ................................................................ 80.6 %  
```

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## License

This application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
