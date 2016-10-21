<?php
namespace Greedy\Database;

// No reconnecting class (Singlton)

use \PDO;

class Connector {

	private static $__connection = null;

	private function __construct()
	{
	}

	public static function Link()
	{
		if (Connector::$__connection == null)
		{
			try {
				global 	$DB_HOST,
						$DB_USER,
						$DB_PASS,
				 		$DB_NAME;

				Connector::$__connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
				Connector::$__connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				die($e->getMessage());
			}
		}
		return Connector::$__connection;
	}
	
}

