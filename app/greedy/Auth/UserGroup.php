<?php
namespace Greedy\Auth;
use \Greedy\Database\Request as Link;

use \PDO;
class UserGroup {

	private $id;
	private $name;
	private $permissions = [];


	public function __construct($id, $group_name)
	{
		$this->id = $id;
		$this->name = $group_name;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_permissions()
	{
		return $this->permissions;
	}

	public function add_permission(Permission $permission)
	{
		array_push($this->permissions, $permission);
	}

	public static function get_user_group($id)
	{
		global $USR_GRP_TBL;
		global $PER_GRP_TBL;

		// Getting group name:
		$user_group = Link::get_first('group_name', USR_GRP_TBL, ['id' => $id]);

		// Create Object:
		$user_group = new UserGroup($id, $user_group['group_name']);
		
		// Getting IDs of permissions that related to this group:
		$per_grp = Link::get('per_id', PER_GRP_TBL, ['user_group_id' => $id]);
		
		// Retrieve permissions and push it to the permissions list:
		foreach ($per_grp as $value)
		{
			array_push($user_group->permissions, Permission::get_permission($value['per_id']));
		}

		foreach ($user_group->get_permissions() as $per) {
			echo $per->get_permission_name().'<br>';
		}

		// Return UserObject:
		return $user_group;
	}

}
