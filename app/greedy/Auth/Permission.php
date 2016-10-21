<?php
namespace Greedy\Auth;
use \PDO;
use \Greedy\Database\Request as Link;

class Permission {

	private $id;
	private $name;
	private $display_name;
	private $component_name;

	public function __construct($name, $display_name, $component_name, $id = 0)
	{
		$this->name = $name;
		$this->display_name = $display_name;
		$this->component_name = $component_name;
		$this->id = $id;
	}

	public function get_permission_name()
	{
		return $this->name;
	}
	
	public static function get_permission($id)
	{

		global $PER_TBL;
		$permission = Link::get_first('*', PER_TBL, ['per_id' => $id]);
		return new Permission($permission['per_name'], $permission['per_dis_name'], $permission['per_component_name'], $id);
		
	}

}