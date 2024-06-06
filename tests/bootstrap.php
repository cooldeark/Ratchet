<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Events\Dispatcher;
use Dotenv\Dotenv;

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load Environment Variables
|--------------------------------------------------------------------------
|
| Here we will load the environment variables from the .env.testing file.
|
*/

$dotenv = Dotenv::createImmutable(__DIR__ . '/..', '.env.testing');
$dotenv->load();

/*
|--------------------------------------------------------------------------
| Set The Default Timezone
|--------------------------------------------------------------------------
|
| Here we will set the default timezone for PHP. PHP is notoriously mean
| if the timezone is not explicitly set. This will be used by each of
| the PHP date and date-time functions throughout the application.
|
*/

date_default_timezone_set('UTC');

/*
 * Prepare the db connection (using PostgreSQL)
 */
echo 'DB_DATABASE: ' . getenv('DB_DATABASE') . PHP_EOL;
$capsule = new Capsule;
$capsule->addConnection([
  'driver'   => 'pgsql',
  'host'     => getenv('DB_HOST'),
  'database' => getenv('DB_DATABASE'),
  'username' => getenv('DB_USERNAME'),
  'password' => getenv('DB_PASSWORD'),
  'charset'  => 'utf8',
  'collation'=> 'utf8_unicode_ci',
  'prefix'   => '',
  'schema'   => 'public',
]);
$capsule->setEventDispatcher(new Dispatcher);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$capsule->schema()->dropIfExists('models');

$capsule->schema()->create('models', function (Blueprint $table) {
    $table->increments('id');
    $table->string('string');
    $table->string('email');
    $table->timestamps();
});

