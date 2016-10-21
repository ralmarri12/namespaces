<?php

include 'core/init.php';

//use Greedy\Auth\User as User;

use Greedy\Router as Router;
use Greedy\Controller as Controller;
use Illuminate\Database\Eloquent\Model as Model;

use Illuminate\Database\Capsule\Manager as Capsule;


$capsule = new Capsule;

$capsule->addConnection([
	'host'			=> '127.0.0.1',
	'port'			=> 8889,
	'driver' 		=> 'mysql',
	'database'		=> 'namespace',
	'username'		=> 'Rash',
	'password'		=> '12341234',
	'charset'		=> 'utf8',
	'collation'		=> 'utf8_unicode_ci',
	'prefix'		=> 'greedy_',
]);

$capsule->bootEloquent();


class User extends Model{
	// protected $primaryKey = 'user_id';
	// public $timestamps = false;
	protected $fillable = [
		'user_login_name',
		'user_email',
		'user_password',
		'user_group_id',
		'attributes',
	];

	protected $table = 'users';
}


//$user = User::get_user(1);

//echo Router::route();

$users = User::all();

foreach ($users as $user) {
	echo $user->user_login_name .' <br> ';
}
// echo '<pre>';

// print_r($users);