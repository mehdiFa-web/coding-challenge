## About the project
this project is built with [laravel](https://laravel.com/docs/8.x) and [vue 3](https://v3.vuejs.org/)

## the following design patterns are used in this project:  
- Repository pattern
- Service pattern
- Pipeline pattern
- Data Transfer Object pattern

### How to set up the back-end :
#### Open the terminal then type the following commands
`cd backend` 
#### Copy .env file then fill database fields
`cp .env.example .env` 
#### Install dependencies
`composer install`  
#### Set the application key
`php artisan key:generate`
#### Migrate the database
`php artisan migrate`
#### Storage link
`php artisan storage:link`

### How to set up the front-end :
#### Open the terminal then type the following commands
`cd frontend` 
#### Install dependencies
`npm install`  
#### Run dev server
`npm run serve`  


**Commands to create Products or Categories:**  
`php artisan create:product`  
`php artisan create:category`

**Commands to delete Products or Categories:**  
`php artisan delete:product`  
`php artisan delete:category`

**you can use laravel sail to run this project:**  
[laravel sail](https://laravel.com/docs/8.x/sail)
`
