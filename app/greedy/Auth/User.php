<?php
namespace Greedy\Auth;


use \Greedy\Database\Request as Link;
use \Greedy\ErrorHandling\EmptyResultSet as EmptyResultSet;
use \PDO;


class User {

	private $id;
	private $login_name;
	private $email;
	private $password;

	private $user_group;
	private $special_permissions = [];

	private $attributes = [];

	public function __construct()
	{
	}

	public function __construct2($login_name, $email, $password, UserGroup $user_group, $id = 0)
	{
		$this->login_name 	= $login_name;
		$this->email 		= $email;
		$this->password 	= $password;
		$this->user_group 	= $user_group;
	}

	public function add_special_permission(Permission $permission)
	{
		array_push($this->special_permissions, $permission);
	}

	private function get_permissions()
	{
		return array_merge($this->special_permissions, $this->user_group->get_permissions());
	}

	public function add_attr($name, $value)
	{
		$attributes[$name] = $value;
	}

	public function get_attr($name)
	{
		if (!isset($attributes[$name]))
			throw new Exception('User:get_attr: attribute '.$name.' is not sat.');

		return $attributes[$name];
	}

	public function has_permission_to($permission_name)
	{
		foreach ($this->get_permissions() as $permission)
		{
			if ( $permission->get_name() === $permission_name )
			{
				return true;
			}
		}
		return false;
	}

	public static function get_user($user_id)
	{
		global $USR_TBL;
		
		try{
			$user = Link::get_first('*', USR_TBL, ['user_id' => 1]);

			$selected_user = new User();

			$selected_user->id = $user['user_id'];
			$selected_user->login_name = $user['user_login_name'];
			$selected_user->email = $user['user_email'];
			$selected_user->password = $user['user_password'];
			$selected_user->user_group = UserGroup::get_user_group($user['user_group_id']);
			$selected_user->attributes = json_decode($user['attributes']);


			return $selected_user;
		} catch (\PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_user_session()
	{
		$permissions_names = [];
		foreach ($this->get_permissions() as $value) {

			array_push($permissions_names, $value->get_permission_name());
		}

		return json_encode([$this->id, json_encode($permissions_names)]);
	}

	public static function login($login_name, $password)
	{
		
		global $USR_TBL;
		try{

			$user = Link::get_first('user_id', USR_TBL, ['user_login_name' => $login_name, 'user_password' => $password]);
			$user = self::get_user($user['user_id']);

			echo $user->login_name;
			$_SESSION['user_id'] = $user->get_user_session();
			return true;
		} catch (EmptyResultSet $e) {
			return false;
		}
	}
}