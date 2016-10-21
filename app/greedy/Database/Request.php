<?php
namespace Greedy\Database;
use Greedy\ErrorHandling\EmptyResultSet as EmptyResultSet;


use \PDO;

class Request {

	

	private static function _get($what = [], $from, $where = [], $extra = '')
	{

		$link = Connector::Link();

		if( is_array($what) )
			$what = '`' . implode( $what, '`,`' ) . '`';

		$sql_statement = 'SELECT ' . $what . ' FROM `' . $from . '`';
		if( count( $where ) != 0 )
			$sql_statement .= ' WHERE ' . self::serialize_where($where);

		if($extra != '')
			$sql_statement .= ' ' . $extra;
		
		$query = $link->query($sql_statement);
		if( $query->rowCount() == 0)
			throw new EmptyResultSet("Error Processing Request", 1);
			
		return $query;
	}

	public static function get($what = [], $from, $where = [], $fetchAll = true, $extra = '')
	{
		if($fetchAll)
			return self::_get($what, $from, $where, $extra)->fetchAll(PDO::FETCH_ASSOC);
		else
			return self::_get($what, $from, $where, $extra)->fetch(PDO::FETCH_ASSOC);
	}


	public static function get_all($from, $where = [])
	{
		$query = self::_get('*', $from, $where);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function get_first($what = [], $from, $where = [])
	{
		$query = self::_get($what, $from, $where, 'LIMIT 1');
		return $query->fetch(PDO::FETCH_ASSOC);
		
	}

	private static function serialize_where($where = [])
	{
		array_walk( $where, create_function('&$i,$k', '$i=" `$k`=\'$i\'";') );
		return trim(implode($where, ' AND '));
	}

}