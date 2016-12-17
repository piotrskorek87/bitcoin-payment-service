<?php

namespace App\Support\Storage;

use App\Support\Storage\Contract\StorageInterface;
use Countable;
use Session;

class SessionStorage implements StorageInterface, Countable
{
	protected $bucket;

	public function __construct($bucket = 'default')
	{
		if (!isset($_SESSION[$bucket])) {
			$_SESSION[$bucket] = [];	
		}

		$this->bucket = $bucket;
	}

	public function set($index, $value)
	{
		Session::put($this->bucket. '.' .$index, $value);
	}

	public function get($index)
	{
		if(!$this->exists($index)){
			return null;
		}

		return Session::get($this->bucket. '.' .$index);
	}

	public function exists($index)
	{
		return Session::has($this->bucket. '.' .$index);
	}

	public function all()
	{
		return Session::get($this->bucket);
	}

	public function remove($index)
	{
		if(!$this->exists($index)){
			return null;
		}

		Session::forget($this->bucket. '.' .$index);
	}

	public function clear()
	{
		Session::forget($this->bucket);		
	}

	public function count()
	{
		return count($this->all());
	}
}
