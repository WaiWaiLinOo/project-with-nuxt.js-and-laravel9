<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirement

<ul>
<li>Php 8.0</li>
<li>Laravel 9</li>
<li>Mysql 8.0</li>
<li>Node 16.17.0 </li>
<li>Composer 2.3.10 </li>
<li>Apache</li>
</ul>

#### Step1 Clone this project

```bash
git clone https://github.com/WaiWaiLinOo/project-with-nuxt.js-and-laravel9.git
```
#### Step2 Start Development Environment

```bash

# For server

cd server

# composer installation

composer install

# Copy env file

copy .env.example .env

# Database setup

DB_DATABASE= 'job-project'
DB_USERNAME= your username
DB_PASSWORD= your password

# Database migrate

php artisan migrate

# key generate

php artisan key:generate

# storage and public connect

php artisan storage:link

# Start laravel server

php artisan serve

http://127.0.0.1:8000

# For client
cd client

# npm installation

npm install

# start 

npm run dev

# now you can create your account and login to create category and post
http://127.0.0.1:3000
# enjoy it

```
