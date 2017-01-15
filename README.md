laravel-admin
=====

[![Build Status](https://travis-ci.org/z-song/laravel-admin.svg?branch=master)](https://travis-ci.org/z-song/laravel-admin)
[![StyleCI](https://styleci.io/repos/48796179/shield)](https://styleci.io/repos/48796179)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/z-song/laravel-admin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/z-song/laravel-admin/?branch=master)
[![Packagist](https://img.shields.io/packagist/l/encore/laravel-admin.svg?maxAge=2592000)](https://packagist.org/packages/encore/laravel-admin)
[![Total Downloads](https://img.shields.io/packagist/dt/encore/laravel-admin.svg?style=flat-square)](https://packagist.org/packages/encore/laravel-admin)

`laravel-admin` is administrative interface builder for laravel which can help you build CRUD backends just with few lines of code.

[Demo](http://120.26.143.106/admin) use `username/password:admin/admin`

Inspired by [SleepingOwlAdmin](https://github.com/sleeping-owl/admin) and [rapyd-laravel](https://github.com/zofe/rapyd-laravel).

[中文文档](/docs/zh/README.md)

Screenshots
------------

![laravel-admin](https://cloud.githubusercontent.com/assets/1479100/19625297/3b3deb64-9947-11e6-807c-cffa999004be.jpg)

Installation
------------

First, install laravel, and make sure that the database connection settings are correct.

```
Laravel 5.1
composer require encore/laravel-admin "1.1.*"

Laravel 5.2
composer require encore/laravel-admin "1.2.*"

Laravel 5.3
composer require encore/laravel-admin "1.3.*"

```

In`config/app.php`add`ServiceProvider`:

```
Encore\Admin\Providers\AdminServiceProvider::class
```

Then run these commands to publish assets and config：

```
php artisan vendor:publish --tag=laravel-admin
```
After run command you can find config file in `config/admin.php`, in this file you can change the install directory,db connection or table names.

At last run following command to finish install. 
```
php artisan admin:install
```

Open `http://localhost/admin/` in browser,use username `admin` and password `admin` to login.

Default Settings
------------
The file in `config/admin.php` contains an array of settings, you can find the default settings in there.

Documentation
------------

- [Quick start](/docs/en/quick-start.md)
- [Router](/docs/en/router.md)
- [Menu](/docs/en/menu.md)
- [Layout](/docs/en/layout.md)
- [Model-grid](/docs/en/model-grid.md)
  - [Row actions](/docs/zh/model-grid-actions.md)
  - [Extend column](/docs/zh/model-grid-column.md)
  - [Custom tools](/docs/zh/grid-custom-tools.md)
- [Model-form](/docs/en/model-form.md)
  - [Form fields](/docs/zh/model-form-fields.md)
  - [Image/File upload](/docs/en/form-upload.md)
  - [Field management](/docs/en/field-management.md)
  - [Form callbacks](/docs/zh/model-form-callback.md)
- [Model-tree](/docs/zh/model-tree.md)
- [widgets](/docs/en/widgets/table.md)
  - [table](/docs/en/widgets/table.md)
  - [form](/docs/en/widgets/form.md)
  - [box](/docs/en/widgets/box.md)
  - [info-box](/docs/en/widgets/info-box.md)
  - [tab](/docs/en/widgets/box.md)
  - [carousel](/docs/en/widgets/carousel.md)
  - [collapse](/docs/en/widgets/collapse.md)
  - charts TODO
- [RBAC](/docs/en/permission.md)

Directory structure
------------
After install,you can find directory`app/Admin`,and then most of our develop work is under this directory.

```

app/Admin
├── Controllers
│   ├── ExampleController.php
│   └── HomeController.php
├── bootstrap.php
└── routes.php
```

`app/Admin/routes.php` is used to define routes，for more detail please read [routes](/docs/zh/router.md).

`app/Admin/bootstrap.php` is bootstrapper for laravel-admin, more usages see comments inside it.

The `app/Admin/Controllers` directory  is used to store all the controllers, The `HomeController.php` file under this directory is used to handle home request of admin,The `ExampleController.php` file is a controller example.

Quick start
------------

We use `users` table come with `Laravel` for example,the structure of table is:
```sql
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```
And the model for this table is `App\User.php`

You can follow these steps to setup `CURD` interfaces of table `users`:

#### 1.add controller

Use the following command to create a controller for `App\User` model

```php
php artisan admin:make UserController --model=App\\User

// under windows use:
php artisan admin:make UserController --model=App\User
```
The above command will create the controller in `app/Admin/Controllers/UserController.php`.

#### 2.add route

Add a route in `app/Admin/routes.php`：
```
$router->resource('users', UserController::class);
```

#### 3.add left menu item

Open `http://localhost:8000/admin/auth/menu`, add menu link and refresh the page, then you can find a link item in left menu bar.

#### 4.build grid and form

The rest needs to be done is open `app/Admin/Contollers/UserController.php`, find `form()` and `grid()` method and write few lines of code with `model-grid` and `model-form`，for more detail, please read [model-grid](/docs/en/model-grid.md) and [model-form](/docs/en/model-form.md).

Other
------------
`laravel-admin` based on following plugins or services:

+ [Laravel](https://laravel.com/)
+ [AdminLTE](https://almsaeedstudio.com/)
+ [Datetimepicker](http://eonasdan.github.io/bootstrap-datetimepicker/)
+ [font-awesome](http://fontawesome.io)
+ [moment](http://momentjs.com/)
+ [Google map](https://www.google.com/maps)
+ [Tencent map](http://lbs.qq.com/)
+ [bootstrap-fileinput](https://github.com/kartik-v/bootstrap-fileinput)
+ [jquery-pjax](https://github.com/defunkt/jquery-pjax)
+ [Nestable](http://dbushell.github.io/Nestable/)
+ [toastr](http://codeseven.github.io/toastr/)
+ [X-editable](http://github.com/vitalets/x-editable)
+ [bootstrap-number-input](https://github.com/wpic/bootstrap-number-input)
+ [fontawesome-iconpicker](https://github.com/itsjavi/fontawesome-iconpicker)

License
------------
`laravel-admin` is licensed under [The MIT License (MIT)](LICENSE).
