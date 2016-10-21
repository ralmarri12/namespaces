<?php namespace Greedy\Form;

class Validator
{


	private   $errors   = [];
	protected $funcs	= [
				'min' 			=> '{field} should be more than {value} characters',
				'max' 			=> '{field} should be less than {value} characters',
				'required'		=> 'Please fill up {field}',
				'alphanumirc' 	=> '{field} should be alphanumirc',
				'int'			=> '{field} should be an integer',
				'email'			=> '{field} is not a valid Email',
				'url'			=> '{field} is not a valid URL',
				'username'		=> '{field} must be alphanumirc starting alphabat character'
			];

	public function __construct($post, $rules)
	{

		$postKeys  = array_keys($post);
		$rulesKeys = array_keys($rules);

		foreach ($rulesKeys as $key => $value)
			if (!in_array($value, $postKeys))
				throw new Exception("{$value} is not found!", 1);
		
		foreach ($rules as $field => $info)
		{
			$name  = $info['name'];
			$rules = json_decode($info['rules']);
			$str   = $post[$field];
			foreach ($rules as $rule => $value) {
				$func = 'valid_'.$rule;
				if(!$this->$func($str, $name, $value))
					$this->errors[] = $this->generateErrorMessage($this->funcs[$rule], ['field' => $name, 'value' => $value]);
			}
		}

	}

	private function generateErrorMessage($message, $values = [])
	{

		$keys = [];
		foreach (array_keys($values) as $key => $value)
			$keys[] = '{'.$value.'}';

		return str_replace($keys, array_values($values), $message).'.';
	}

	protected function valid_min($str, $name, $value)
	{
		return (strlen($str) > $value);
	}

	protected function valid_email($str, $name, $value){
		return (filter_var($str, FILTER_VALIDATE_EMAIL));
	}

	protected function valid_url($str, $name, $value){
		return (filter_var($str, FILTER_VALIDATE_URL));
	}

	protected function valid_max($str, $name, $value)
	{
		return (strlen($str) < $value);
	}

	protected function valid_required($str, $name, $value)
	{
		return ($str != '');
	}

	protected function valid_int($str, $name, $value)
	{
		return (is_int($str));
	}

	protected function valid_alphanumirc($str, $name, $value)
	{
		return (ctype_alnum($str));
	}

	protected function valid_username($str, $name, $value)
	{
	return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$str);
	}

	public function hasErrors()
	{
		return (!empty($this->errors));
	}

	public function getErrors(){
		return $this->errors;
	}

}

?>





