<?php
namespace Greedy\ErrorHandling;
use \Exception;



class GreedyException extends Exception {

	public function __construct($message = null, $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	// @override
	public function __toString()
	{
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

}