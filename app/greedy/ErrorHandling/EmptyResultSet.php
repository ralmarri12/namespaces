<?php
namespace Greedy\ErrorHandling;
use \Exception;



class EmptyResultSet extends GreedyException {
	public function __construct($message = null, $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}