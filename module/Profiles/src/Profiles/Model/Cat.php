<?php
namespace Profiles\Model;

class Cat
{
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}