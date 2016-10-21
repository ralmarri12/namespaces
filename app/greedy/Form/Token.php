<?php

namespace Greedy\Form;

class Token {

	public static function generate()
	{
		return $_SESSION['Token'] = base64_encode( openssl_random_pseudo_bytes(32) );
	}

	public static function check($token)
	{
		if( isset($_SESSION['Token']) )
			if ($token === $_SESSION['Token'])
			{
				unset($_SESSION['Token']);
				return true;
			}

		return false;
	}

}