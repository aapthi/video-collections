<?php
namespace Users\Model;

class TypeOfVideo
{
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}