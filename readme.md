![alt tag](https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHomeLogo-body-only300.png)

# app.Rentling v1

## app.Rentling v1 - born out of Rentomato v2 app based on Laravel5
* [Requirements](#feature2)
* [How to install](#feature3)
* [Application Structure](#feature4)

-----

##Requirements

	PHP >= 5.5.9
	OpenSSL PHP Extension
	Mbstring PHP Extension
	Tokenizer PHP Extension
	SQL server(for example MySQL)
	Composer
	Node JS

-----

##How to install:
* [Step 1: Get the code](#step1)
* [Step 2: Use Composer to install dependencies](#step2)
* [Step 3: Configure Mailer](#step3)
* [Step 4: Create database](#step4)
* [Step 5: Install](#step5)
* [Step 6: Start Page](#step6)

-----

### Step 1: Get the code - Download the repository

-----

### Step 2: Use Composer to install dependencies

Laravel utilizes [Composer](http://getcomposer.org/) to manage its dependencies. First, download a copy of the composer.phar.
Once you have the PHAR archive, you can either keep it in your local project directory or move to
usr/local/bin to use it globally on your system.
On Windows, you can use the Composer [Windows installer](https://getcomposer.org/Composer-Setup.exe).

Then run:

    composer install
to install dependencies Laravel and other packages.

-----

### Step 3: Configure Mailer

In the same fashion, copy the ***config/mail.php*** configuration file in ***config/local/mail.php***. Now set the `address` and `name` from the `from` array in ***config/mail.php***. Those will be used to send account confirmation and password reset emails to the users.
If you don't set that registration will fail because it cannot send the confirmation email.

-----

### Step 4: Create database

If you finished first three steps, now you can create database on your database server(MySQL). You must create database
with utf-8 collation(uft8_general_ci), to install and application work perfectly.
After that, copy .env.example and rename it as .env and put connection and change default database connection name, only database connection, put name database, database username and password.

-----

### Step 5: Install

Firstable need to uncomment this line "extension=php_fileinfo.dll" in php.info file.

This project makes use of Bower and Laravel Elixir. Before triggering Elixir, you must first ensure that Node.js (included in homestead) is installed on your machine.

    node -v

Install dependencies listed in package.json with:

    npm install

If installing under Windows, try this instead:

    npm install --global --production windows-build-tools
    npm update

If running under Windows, install bower, gulp, elixir:

    npm install -g bower
    npm install -g gulp
    npm install laravel-elixir

Install all frontend dependencies with Bower:


```
#!shell

   bower install (with flag --allow-root if running as sudo)
```


Compile SASS, and move frontend files into place:

    gulp

Now that you have the environment configured, you need to create a database configuration for it. For create database tables use this command:

    php artisan migrate

And to initial populate database use this:

    // php artisan db:seed
    23Apr seeder will give errors. Best to import the AWS-RENTLING_20APR-4CODERS.SQL and then run migrations. This method gives better testing data.

-----

### Step 6: Start Page

To login into the admin please check the UsersTableSeeder.php and pick a user to login.

### Step 7: Reading material for new team members
https://rentling.atlassian.net/wiki/spaces/DEV/pages/262715/Development+Workflow

-----

## Troubleshooting

### RuntimeException : No supported encrypter found. The cipher and / or key length are invalid.

php artisan key:generate

### Cache busting with Elixir
Version-ing of css an javascript is achieved through laravel-elixir. If your javascript or css changes aren't coming through, make sure your work is picked up by gulpfile.js when running gulp.

Note: Blade gets the path to a versioned Elixir file with the following method call:

    elixir($file);

### Site loading very slow

	composer dump-autoload --optimize
OR

    php artisan dump-autoload

-----

## License

This is free software distributed under the terms of the MIT license

-----

## Additional information

###Disable gulp-notify
If you are running on a system that handles notifications poorly or you simply do not wish to use gulp-notify but your project does? You can disable gulp-notify by using enviroment variable DISABLE_NOTIFIER.

    export DISABLE_NOTIFIER=true;